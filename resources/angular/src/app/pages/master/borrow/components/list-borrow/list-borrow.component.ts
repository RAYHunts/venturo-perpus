import { Component, OnInit, ViewChild } from "@angular/core";
import { DataTableDirective } from "angular-datatables";
import { LandaService } from "src/app/core/services/landa.service";
import { AuthService } from "src/app/pages/auth/services/auth.service";
import { BorrowService } from "../../services/borrow.service";
// import Swal from 'sweetalert2';

@Component({
    selector: "app-list-borrow",
    templateUrl: "./list-borrow.component.html",
    styleUrls: ["./list-borrow.component.scss"],
})
export class ListBorrowComponent implements OnInit {
    @ViewChild(DataTableDirective) dtElement: DataTableDirective;
    dtOptions: any;
    listBorrows: [];
    titleCard: string;
    modelId: number;
    isOpenForm: boolean = false;
    userLogin;

    constructor(
        private borrowService: BorrowService,
        private landaService: LandaService,
        private authService: AuthService
    ) {}

    ngOnInit(): void {
        this.getUserLogin();
    }

    getUserLogin() {
        this.authService.getProfile().subscribe((user: any) => {
            this.userLogin = user;
            if (this.userLogin.is_admin) {
                this.getBorrow();
            } else {
                this.getBorrowbyUserID(this.userLogin.id);
            }
        });
    }

    getBorrow() {
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
                this.borrowService.getBorrows(params).subscribe((res: any) => {
                    this.listBorrows = res.data.list;
                    callback({
                        recordsTotal: res.data.meta.total,
                        recordsFiltered: res.data.meta.total,
                        data: [],
                    });
                });
            },
        };
    }

    getBorrowbyUserID(user_id) {
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
                    user_id: user_id,
                };
                this.borrowService
                    .getBorrowsByUser(params)
                    .subscribe((res: any) => {
                        this.listBorrows = res.data.list;
                        callback({
                            recordsTotal: res.data.meta.total,
                            recordsFiltered: res.data.meta.total,
                            data: [],
                        });
                    });
            },
        };
    }

    reloadDataTable(): void {
        this.dtElement.dtInstance.then((dtInstance: DataTables.Api) => {
            dtInstance.draw();
        });
    }

    showForm(show) {
        this.isOpenForm = show;
    }

    createBorrow() {
        this.titleCard = "Tambah Peminjaman";
        this.modelId = 0;
        this.showForm(true);
    }

    updateBorrow(borrowModel) {
        this.titleCard = "Update Peminjaman";
        this.modelId = borrowModel.id;
        this.showForm(true);
    }

    return(payload) {
        console.log(payload);
        this.borrowService.returnBorrow(payload).subscribe(
            (res: any) => {
                this.landaService.alertSuccess(
                    "Berhasil",
                    "Buku Berhasil dikembalikan"
                );
                this.reloadDataTable();
            },
            (err) => {
                this.landaService.alertError("Mohon Maaf", err.error.errors);
            }
        );
    }
}
