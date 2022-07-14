import { Component, EventEmitter, Input, OnInit, Output, SimpleChange } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';
import { CustomerService } from '../../services/customer.service';

@Component({
    selector: 'customer-form',
    templateUrl: './form-customer.component.html',
    styleUrls: ['./form-customer.component.scss']
})
export class FormCustomerComponent implements OnInit {
    @Input() customerId: number;
    @Output() afterSave  = new EventEmitter<boolean>();
    mode: string;
    formModel : {
        id: number,
        nama: string,
        email: string,
        is_verified: boolean
    }

    constructor(
        private customerService: CustomerService,
        private landaService: LandaService
    ) {}

    ngOnInit(): void {

    }
    
    ngOnChanges(changes: SimpleChange) {
        this.emptyForm();
    }

    emptyForm() {
        this.mode = 'add';
        this.formModel = {
            id: 0,
            nama: '',
            email: '',
            is_verified: false
        }

        if (this.customerId > 0) {
            this.mode = 'edit';
            this.getCustomer(this.customerId);
        }
    }

    save() {
        if(this.mode == 'add') {
            this.customerService.createCustomer(this.formModel).subscribe((res : any) => {
                this.landaService.alertSuccess('Berhasil', res.message);
                this.afterSave.emit();
            }, err => {
                this.landaService.alertError('Mohon Maaf', err.error.errors);
            });
        } else {
            this.customerService.updateCustomer(this.formModel).subscribe((res : any) => {
                this.landaService.alertSuccess('Berhasil', res.message);
                this.afterSave.emit();
            }, err => {
                this.landaService.alertError('Mohon Maaf', err.error.errors);
            });
        }
    }

    getCustomer(customerId) {
        this.customerService.getCustomerById(customerId).subscribe((res: any) => {
            this.formModel = res.data;
        }, err => {
            console.log(err);
        });
    }
}
