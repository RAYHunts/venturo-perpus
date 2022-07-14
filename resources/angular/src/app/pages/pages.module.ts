import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { ReactiveFormsModule } from "@angular/forms";

import { PerfectScrollbarModule } from "ngx-perfect-scrollbar";
import { PERFECT_SCROLLBAR_CONFIG } from "ngx-perfect-scrollbar";
import { PerfectScrollbarConfigInterface } from "ngx-perfect-scrollbar";
import { NgbAlertModule } from "@ng-bootstrap/ng-bootstrap";

import { PagesRoutingModule } from "./pages-routing.module";

import { DashboardComponent } from "./dashboard/dashboard.component";

const DEFAULT_PERFECT_SCROLLBAR_CONFIG: PerfectScrollbarConfigInterface = {
    suppressScrollX: true,
    wheelSpeed: 0.3,
};

@NgModule({
    declarations: [DashboardComponent],
    imports: [
        ReactiveFormsModule,
        CommonModule,
        NgbAlertModule,
        PagesRoutingModule,
        PerfectScrollbarModule,
    ],
    providers: [
        {
            provide: PERFECT_SCROLLBAR_CONFIG,
            useValue: DEFAULT_PERFECT_SCROLLBAR_CONFIG,
        },
    ],
})
export class PagesModule {}
