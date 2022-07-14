import { Component, OnInit } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { LandaService } from 'src/app/core/services/landa.service';
import Swal from 'sweetalert2';
import { CustomerService } from '../../services/customer.service';

@Component({
    selector: 'customer-daftar',
    templateUrl: './daftar-customer.component.html',
    styleUrls: ['./daftar-customer.component.scss']
})
export class DaftarCustomerComponent implements OnInit {

    listCustomer: [];
    titleModal: string;
    modelId: number;

    constructor(
        private customerService: CustomerService,
        private landaService: LandaService,
        private modalService: NgbModal
    ) { }

    ngOnInit(): void {
        this.getCustomer();
    }

    trackByIndex(index: number): any {
        return index;
    }

    getCustomer() {
        this.customerService.getCustomers([]).subscribe((res: any) => {
            this.listCustomer = res.data.list;
        }, (err: any) => {
            console.log(err);
        });
    }

    createCustomer(modal) {
        this.titleModal = 'Tambah Customer';
        this.modelId = 0;
        this.modalService.open(modal, { size: 'lg', backdrop: 'static' });
    }

    updateCustomer(modal, customerModel) {
        this.titleModal = 'Edit Customer: ' + customerModel.nama;
        this.modelId = customerModel.id;
        this.modalService.open(modal, { size: 'lg', backdrop: 'static' });
    }

    deleteCustomer(userId) {
        Swal.fire({
            title: 'Apakah kamu yakin ?',
            text: 'Customer tidak dapat melakukan pesanan setelah kamu menghapus datanya',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34c38f',
            cancelButtonColor: '#f46a6a',
            confirmButtonText: 'Ya, Hapus data ini !',
        }).then((result) => {
            if (result.value) {
                this.customerService.deleteCustomer(userId).subscribe((res: any) => {
                    this.landaService.alertSuccess('Berhasil', res.message);
                    this.getCustomer();
                }, err => {
                    console.log(err);
                });
            }
        });
    }
}
