import { Component, OnInit, ViewChild } from "@angular/core";
import { DataTableDirective } from "angular-datatables";
import { BookService } from "../../../books/services/book.service";

@Component({
    selector: "app-laporan-buku",
    templateUrl: "./laporan-buku.component.html",
    styleUrls: ["./laporan-buku.component.scss"],
})
export class LaporanBukuComponent implements OnInit {
    @ViewChild(DataTableDirective) dtElement: DataTableDirective;
    dtInstance: Promise<DataTables.Api>;
    dtOptions: any;
    listBooks: [];
    constructor(private bookService: BookService) {}

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
                    borrowed: true,
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
}
