import { Component, OnInit, ViewChild } from "@angular/core";
import { DataTableDirective } from "angular-datatables";
import { LandaService } from "src/app/core/services/landa.service";
import { AuthService } from "src/app/pages/auth/services/auth.service";
import Swal from "sweetalert2";
import { BookService } from "../../services/book.service";

@Component({
    selector: "app-list-books",
    templateUrl: "./list-books.component.html",
    styleUrls: ["./list-books.component.scss"],
})
export class ListBooksComponent implements OnInit {
    @ViewChild(DataTableDirective) dtElement: DataTableDirective;
    dtInstance: Promise<DataTables.Api>;
    dtOptions: any;
    listBooks: [];
    titleCard: string;
    modelId: number;
    isOpenForm: boolean = false;
    userLogin;

    constructor(
        private bookService: BookService,
        private landaService: LandaService,
        private authService: AuthService
    ) {}

    ngOnInit(): void {
        this.getBook();
        this.authService.getProfile().subscribe((user: any) => {
            this.userLogin = user;
        });
    }

    reloadDataTable(): void {
        this.dtElement.dtInstance.then((dtInstance: DataTables.Api) => {
            dtInstance.draw();
        });
    }

    getBook() {
        this.dtOptions = {
            serverSide: true,
            processing: true,
            ordering: false,
            searching: false,
            pagingType: "full_numbers",
            ajax: (dataTablesParameter: any, callback) => {
                const page =
                    parseInt(dataTablesParameter.start) /
                        parseInt(dataTablesParameter.length) +
                    1;
                const params = {
                    page: page,
                    offset: dataTablesParameter.start,
                    limit: dataTablesParameter.length,
                };
                this.bookService.getBooks(params).subscribe(
                    (res: any) => {
                        this.listBooks = res.data.list;
                        callback({
                            recordsTotal: res.data.meta.total,
                            recordsFiltered: res.data.meta.total,
                            data: [],
                        });
                    },
                    (err: any) => {
                        console.log(err);
                    }
                );
            },
        };
    }

    showForm(show) {
        this.isOpenForm = show;
    }

    createBook() {
        this.titleCard = "Tambah Buku";
        this.modelId = 0;
        this.showForm(true);
    }

    updateBook(bookModel) {
        this.titleCard = "Edit Buku : " + bookModel.title;
        this.modelId = bookModel.id;
        this.showForm(true);
    }

    borrowBook(user_id, book_id) {
        this.bookService.borrowBook(user_id, book_id).subscribe((res: any) => {
            this.landaService.alertSuccess("Berhasil", res.message);
            this.reloadDataTable();
        });
    }

    deleteBook(bookId) {
        Swal.fire({
            title: "Apakah kamu yakin ?",
            text: "Buku ini akan dihapus",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
        }).then((result) => {
            if (result.value) {
                this.bookService.deleteBook(bookId).subscribe(
                    (res: any) => {
                        this.landaService.alertSuccess("Berhasil", res.message);
                        this.reloadDataTable();
                    },
                    (err: any) => {
                        console.log(err);
                    }
                );
            }
        });
    }
}
