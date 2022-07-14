import { AsyncPipe } from "@angular/common";
import { BrowserModule } from "@angular/platform-browser";
import { BrowserAnimationsModule } from "@angular/platform-browser/animations";
import { NgModule } from "@angular/core";
import {
    HTTP_INTERCEPTORS,
    HttpClient,
    HttpClientModule,
} from "@angular/common/http";
import { HttpConfigInterceptor } from "./core/interceptors/http-config.interceptor";

import { initFirebaseBackend } from "./authUtils";
import { environment } from "../environments/environment";

import { LayoutsModule } from "./layouts/layouts.module";
import { AppRoutingModule } from "./app-routing.module";
import { AppComponent } from "./app.component";
import { AuthService } from "./pages/auth/services/auth.service";

initFirebaseBackend(environment.firebaseConfig);

@NgModule({
    declarations: [AppComponent],
    imports: [
        BrowserModule,
        BrowserAnimationsModule,
        LayoutsModule,
        AppRoutingModule,
        HttpClientModule,
    ],
    providers: [
        AsyncPipe,
        {
            provide: HTTP_INTERCEPTORS,
            useClass: HttpConfigInterceptor,
            multi: true,
        },
    ],
    bootstrap: [AppComponent],
})
export class AppModule {
    constructor(private authService: AuthService) {
        this.authService.saveCsrf();

        if (this.authService.getToken() !== "") {
            this.authService.saveUserLogin();
        }
    }
}
