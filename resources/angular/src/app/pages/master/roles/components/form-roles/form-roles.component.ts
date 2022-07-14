import {
    Component,
    Input,
    OnInit,
    Output,
    SimpleChange,
    EventEmitter,
} from "@angular/core";

import { LandaService } from "src/app/core/services/landa.service";
import { RoleService } from "../../../roles/services/role-service.service";

@Component({
    selector: "role-form",
    templateUrl: "./form-roles.component.html",
    styleUrls: ["./form-roles.component.scss"],
})
export class FormRolesComponent implements OnInit {
    @Input() roleId: number;
    @Output() afterSave = new EventEmitter<boolean>();
    mode: string;
    listAkses: [];
    formModel: {
        id: number;
        nama: string;
        akses: {
            user: {
                create: boolean;
                update: boolean;
                delete: boolean;
                view: boolean;
            };
            roles: {
                create: boolean;
                update: boolean;
                delete: boolean;
                view: boolean;
            };
            books: {
                create: boolean;
                update: boolean;
                delete: boolean;
                view: boolean;
            };
            borrow: {
                create: boolean;
                update: boolean;
                delete: boolean;
                view: boolean;
            };
        };
    };

    constructor(
        private roleService: RoleService,
        private landaService: LandaService
    ) {}

    ngOnInit(): void {}

    ngOnChanges(changes: SimpleChange) {
        this.emptyForm();
    }

    emptyForm() {
        this.mode = "add";
        this.formModel = {
            id: 0,
            nama: "",
            akses: {
                user: {
                    create: false,
                    update: false,
                    delete: false,
                    view: false,
                },
                roles: {
                    create: false,
                    update: false,
                    delete: false,
                    view: false,
                },
                books: {
                    create: false,
                    update: false,
                    delete: false,
                    view: false,
                },
                borrow: {
                    create: false,
                    update: false,
                    delete: false,
                    view: false,
                },
            },
        };

        if (this.roleId > 0) {
            this.mode = "edit";
            this.getRole(this.roleId);
        }
    }

    getRole(roleId) {
        this.roleService.getRoleById(roleId).subscribe(
            (res: any) => {
                this.formModel.id = res.data.id;
                this.formModel.nama = res.data.nama;

                // Detail hak akses
                const akses = res.data.akses;
                for (const key in akses) {
                    this.formModel.akses[key] = akses[key];
                }
            },
            (err) => {
                console.log(err);
            }
        );
    }

    save() {
        if (this.mode == "add") {
            this.roleService.createRole(this.formModel).subscribe(
                (res: any) => {
                    this.landaService.alertSuccess("Berhasil", res.message);
                    this.afterSave.emit();
                },
                (err) => {
                    this.landaService.alertError(
                        "Mohon Maaf",
                        err.error.errors
                    );
                }
            );
        } else {
            this.roleService.updateRole(this.formModel).subscribe(
                (res: any) => {
                    this.landaService.alertSuccess("Berhasil", res.message);
                    this.afterSave.emit();
                },
                (err) => {
                    this.landaService.alertError(
                        "Mohon Maaf",
                        err.error.errors
                    );
                }
            );
        }
    }
}
