import { Component, OnInit, ViewChild } from "@angular/core";
import { DataTableDirective } from "angular-datatables";
import { LandaService } from "src/app/core/services/landa.service";
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

    constructor(
        private bookService: BookService,
        private landaService: LandaService
    ) {}

    ngOnInit(): void {
        this.getBook();
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
                        this.getBook();
                    },
                    (err: any) => {
                        console.log(err);
                    }
                );
            }
        });
    }
}
