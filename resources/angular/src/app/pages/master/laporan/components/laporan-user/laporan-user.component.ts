import { Component, OnInit, ViewChild } from "@angular/core";
import { DataTableDirective } from "angular-datatables";
import { UserService } from "../../../users/services/user-service.service";

@Component({
    selector: "app-laporan-user",
    templateUrl: "./laporan-user.component.html",
    styleUrls: ["./laporan-user.component.scss"],
})
export class LaporanUserComponent implements OnInit {
    @ViewChild(DataTableDirective) dtElement: DataTableDirective;
    dtInstance: Promise<DataTables.Api>;
    dtOptions: any;
    listUser: [];
    constructor(private userService: UserService) {}

    ngOnInit(): void {
        this.getUser();
    }

    getUser() {
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
                    borrowing: true,
                };
                this.userService.getUsers(params).subscribe(
                    (res: any) => {
                        this.listUser = res.data.list;
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
