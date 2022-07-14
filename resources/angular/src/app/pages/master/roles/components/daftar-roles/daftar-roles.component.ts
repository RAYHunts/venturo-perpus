import { Component, OnInit, ViewChild } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { LandaService } from 'src/app/core/services/landa.service';
import { DataTableDirective } from 'angular-datatables';
import Swal from 'sweetalert2';

import { RoleService } from '../../services/role-service.service';

@Component({
    selector: 'role-daftar',
    templateUrl: './daftar-roles.component.html',
    styleUrls: ['./daftar-roles.component.scss']
})
export class DaftarRolesComponent implements OnInit {
    // Datatable
    @ViewChild(DataTableDirective) dtElement: DataTableDirective;
    dtInstance: Promise<DataTables.Api>;
    dtOptions: any;

    listRoles: [];
    titleModal: string;
    modelId: number;

    constructor(
        private roleService: RoleService,
        private landaService: LandaService,
        private modalService: NgbModal,
    ) { }

    ngOnInit(): void {
        this.getRoles();
    }

    trackByIndex(index: number): any {
        return index;
    }

    reloadDataTable(): void {
        this.dtElement.dtInstance.then((dtInstance: DataTables.Api) => {
            dtInstance.draw();
        });
    }

    getRoles() {
        this.dtOptions = {
            serverSide: true,
            processing: true,
            ordering: false,
            pagingType: 'full_numbers',
            ajax: (dataTablesParameters: any, callback) => {
                const params = {
                    filter: JSON.stringify({}),
                    offset: dataTablesParameters.start,
                    limit: dataTablesParameters.length,
                };
                this.roleService.getRoles([]).subscribe((res: any) => {
                    this.listRoles = res.data.list;

                    callback({
                        recordsTotal: res.data.meta.total,
                        recordsFiltered: res.data.meta.total,
                        data: [],
                    });
                }, (err: any) => {
                    console.log(err);
                });
            },
        };
        // this.roleService.getRoles([]).subscribe((res: any) => {
        //     this.listRoles = res.data.list;
        // }, (err: any) => {
        //     console.log(err);
        // });
    }

    createRole(modal) {
        this.titleModal = 'Tambah Hak Akses';
        this.modelId = 0;
        this.modalService.open(modal, { size: 'lg', backdrop: 'static' });
    }

    updateRole(modal, roleModel) {
        this.titleModal = 'Edit Hak Akses: ' + roleModel.nama;
        this.modelId = roleModel.id;
        this.modalService.open(modal, { size: 'lg', backdrop: 'static' });
    }

    deleteRole(roleId) {
        Swal.fire({
            title: 'Apakah kamu yakin ?',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34c38f',
            cancelButtonColor: '#f46a6a',
            confirmButtonText: 'Ya, Hapus data ini !',
        }).then((result) => {
            if (result.value) {
                this.roleService.deleteRole(roleId).subscribe((res: any) => {
                    this.landaService.alertSuccess('Berhasil', res.message);
                    this.getRoles();
                }, err => {
                    console.log(err);
                });
            }
        });
    }
}
