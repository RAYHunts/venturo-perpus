import { NgModule } from "@angular/core";
import { Routes, RouterModule } from "@angular/router";
import { ListBooksComponent } from "./books/components/list-books/list-books.component";
import { ListBorrowComponent } from "./borrow/components/list-borrow/list-borrow.component";
import { DaftarCustomerComponent } from "./customers/components/daftar-customer/daftar-customer.component";
import { DaftarItemComponent } from "./items/components/daftar-item/daftar-item.component";
import { DaftarRolesComponent } from "./roles/components/daftar-roles/daftar-roles.component";
import { DaftarUserComponent } from "./users/components/daftar-user/daftar-user.component";

const routes: Routes = [
    { path: "users", component: DaftarUserComponent },
    { path: "roles", component: DaftarRolesComponent },
    { path: "customers", component: DaftarCustomerComponent },
    { path: "items", component: DaftarItemComponent },
    { path: "books", component: ListBooksComponent },
    { path: "borrows", component: ListBorrowComponent },
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class MasterRoutingModule {}
