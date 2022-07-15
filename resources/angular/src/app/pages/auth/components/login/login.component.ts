import { Component, OnInit, AfterViewInit } from "@angular/core";

import { LandaService } from "../../../../core/services/landa.service";
import { Router } from "@angular/router";
import { AuthService } from "../../services/auth.service";

@Component({
    selector: "app-login",
    templateUrl: "./login.component.html",
    styleUrls: ["./login.component.scss"],
})

/**
 * Login component
 */
export class LoginComponent implements OnInit, AfterViewInit {
    email: string;
    password: string;
    year: number = new Date().getFullYear();

    constructor(
        private authService: AuthService,
        private landaService: LandaService,
        private router: Router
    ) {
        if (this.authService.getToken() !== "") {
            this.router.navigate(["/home"]);
        }
    }

    ngOnInit() {
        this.authService.logout();
    }

    ngAfterViewInit() {}

    login() {
        this.authService.login(this.email, this.password).subscribe(
            (res: any) => {
                this.authService.saveToken(res.data.access_token);
                window.location.href = "/home";
            },
            (err: any) => {
                this.landaService.alertError("Mohon Maaf", err.error.errors);
            }
        );
    }
}
