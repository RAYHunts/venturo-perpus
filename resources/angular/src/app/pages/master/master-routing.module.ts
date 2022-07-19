import { NgModule } from "@angular/core";
import { Routes, RouterModule } from "@angular/router";
import { ListBooksComponent } from "./books/components/list-books/list-books.component";
import { ListBorrowComponent } from "./borrow/components/list-borrow/list-borrow.component";
import { LaporanBukuComponent } from "./laporan/components/laporan-buku/laporan-buku.component";
import { LaporanUserComponent } from "./laporan/components/laporan-user/laporan-user.component";
import { DaftarRolesComponent } from "./roles/components/daftar-roles/daftar-roles.component";
import { DaftarUserComponent } from "./users/components/daftar-user/daftar-user.component";
import { ProfileUserComponent } from "./users/components/profile-user/profile-user.component";

const routes: Routes = [
    { path: "users", component: DaftarUserComponent },
    { path: "roles", component: DaftarRolesComponent },
    { path: "books", component: ListBooksComponent },
    { path: "borrows", component: ListBorrowComponent },
    { path: "books-report", component: LaporanBukuComponent },
    { path: "users-report", component: LaporanUserComponent },
    { path: "profile", component: ProfileUserComponent },
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class MasterRoutingModule {}
