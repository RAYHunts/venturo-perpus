import { Injectable } from "@angular/core";
import { LandaService } from "src/app/core/services/landa.service";

@Injectable({
    providedIn: "root",
})
export class BookService {
    constructor(private landaService: LandaService) {}

    getBooks(arrParameter) {
        return this.landaService.DataGet("/v1/books", arrParameter);
    }

    getBookById(bookId) {
        return this.landaService.DataGet("/v1/books/" + bookId);
    }

    createBook(payload) {
        return this.landaService.DataPost("/v1/books", payload);
    }

    updateBook(payload) {
        return this.landaService.DataPut("/v1/books", payload);
    }

    deleteBook(bookId) {
        return this.landaService.DataDelete("/v1/books/" + bookId);
    }
}
