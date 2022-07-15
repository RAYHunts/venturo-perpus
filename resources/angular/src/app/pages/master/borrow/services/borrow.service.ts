import { Injectable } from "@angular/core";
import { LandaService } from "src/app/core/services/landa.service";

@Injectable({
    providedIn: "root",
})
export class BorrowService {
    constructor(private landaService: LandaService) {}

    getBorrows(arrParameter) {
        return this.landaService.DataGet("/v1/borrows", arrParameter);
    }

    getBorrowsByUser(arrParameter) {
        return this.landaService.DataGet("/v1/borrows/user", arrParameter);
    }

    getBorrowById(id) {
        return this.landaService.DataGet("/v1/borrows/" + id);
    }

    createBorrow(payload) {
        return this.landaService.DataPost("/v1/borrows", payload);
    }

    updateBorrow(payload) {
        return this.landaService.DataPut("/v1/borrows", payload);
    }

    returnBorrow(payload) {
        payload = {
            book_id: payload.book.id,
            user_id: payload.user.id,
            id: payload.id,
        };
        return this.landaService.DataPut("/v1/borrows", payload);
    }

    deleteBorrow(id) {
        return this.landaService.DataDelete("/v1/borrows/" + id);
    }

    getUsers() {
        return this.landaService.DataGet("/v1/users", { limit: 0 });
    }

    getBooks() {
        return this.landaService.DataGet("/v1/books", {
            limit: 0,
            sort: "title",
        });
    }
}
