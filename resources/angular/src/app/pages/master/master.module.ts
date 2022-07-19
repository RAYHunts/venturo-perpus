import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { FormsModule } from "@angular/forms";

import {
    NgbModule,
    NgbTooltipModule,
    NgbModalModule,
} from "@ng-bootstrap/ng-bootstrap";
import { NgSelectModule } from "@ng-select/ng-select";
import { DataTablesModule } from "angular-datatables";

import { MasterRoutingModule } from "./master-routing.module";
import { DaftarUserComponent } from "./users/components/daftar-user/daftar-user.component";
import { FormUserComponent } from "./users/components/form-user/form-user.component";
import { DaftarRolesComponent } from "./roles/components/daftar-roles/daftar-roles.component";
import { FormRolesComponent } from "./roles/components/form-roles/form-roles.component";
import { ListBooksComponent } from "./books/components/list-books/list-books.component";
import { FormBookComponent } from "./books/components/form-book/form-book.component";
import { ListBorrowComponent } from "./borrow/components/list-borrow/list-borrow.component";
import { FormBorrowComponent } from "./borrow/components/form-borrow/form-borrow.component";
import { LaporanBukuComponent } from "./laporan/components/laporan-buku/laporan-buku.component";
import { LaporanUserComponent } from "./laporan/components/laporan-user/laporan-user.component";
import { ProfileUserComponent } from "./users/components/profile-user/profile-user.component";

@NgModule({
    declarations: [
        DaftarUserComponent,
        FormUserComponent,
        DaftarRolesComponent,
        FormRolesComponent,
        ListBooksComponent,
        FormBookComponent,
        ListBorrowComponent,
        FormBorrowComponent,
        LaporanBukuComponent,
        LaporanUserComponent,
        ProfileUserComponent,
    ],
    imports: [
        CommonModule,
        MasterRoutingModule,
        NgbModule,
        NgbTooltipModule,
        NgbModalModule,
        NgSelectModule,
        FormsModule,
        DataTablesModule,
    ],
})
export class MasterModule {}
