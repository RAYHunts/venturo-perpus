import { Component, OnInit, SimpleChange } from "@angular/core";
import { AuthService } from "src/app/pages/auth/services/auth.service";
import { Observable, Subscriber } from "rxjs";
import { LandaService } from "src/app/core/services/landa.service";
import { RoleService } from "../../../roles/services/role-service.service";
import { UserService } from "../../services/user-service.service";
import { Router } from "@angular/router";

@Component({
    selector: "app-profile-user",
    templateUrl: "./profile-user.component.html",
    styleUrls: ["./profile-user.component.scss"],
})
export class ProfileUserComponent implements OnInit {
    currentImage: string;
    userLogin: any;
    listAkses: any[] = [];
    formModel: {
        id;
        akses;
        nama;
        foto;
        email;
        password;
        passwordConfirm;
    };
    constructor(
        private authService: AuthService,
        private roleService: RoleService,
        private userService: UserService,
        private landaService: LandaService,
        private router: Router
    ) {}

    ngOnInit(): void {
        this.getRole();
        this.emptyForm();
        this.authService.getProfile().subscribe((res: any) => {
            this.getUser(res.id);
        });
    }

    ngOnChanges(changes: SimpleChange) {
        this.emptyForm();
    }

    emptyForm() {
        this.formModel = {
            id: "",
            akses: "",
            nama: "",
            foto: "",
            email: "",
            password: "",
            passwordConfirm: "",
        };
    }

    onFileChange(event) {
        const file = event.target.files[0];
        this.convertToBase64(file);
    }

    convertToBase64(file: File) {
        new Observable((subscriber: Subscriber<any>) => {
            this.readFile(file, subscriber);
        }).subscribe((image) => {
            this.formModel.foto = image;
        });
    }

    readFile(file, subscriber: Subscriber<any>) {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);
        fileReader.onload = () => {
            subscriber.next(fileReader.result);
            subscriber.complete();
        };
        fileReader.onerror = (error) => {
            subscriber.error(error);
            subscriber.complete();
        };
    }
    getRole() {
        this.roleService.getRoles([]).subscribe(
            (res: any) => {
                this.listAkses = res.data.list;
            },
            (err) => {
                console.log(err);
            }
        );
    }

    getUser(userId) {
        this.userService.getUserById(userId).subscribe(
            (res: any) => {
                this.formModel = {
                    id: res.data.id,
                    akses: res.data.akses,
                    nama: res.data.nama,
                    foto: res.data.fotoUrl,
                    email: res.data.email,
                    password: null,
                    passwordConfirm: null,
                };
            },
            (err) => {
                console.log(err);
            }
        );
    }

    onSubmit() {
        if (this.formModel.password == this.formModel.passwordConfirm) {
            this.userService.updateUser(this.formModel).subscribe(
                (res: any) => {
                    this.landaService.alertSuccess("Berhasil", res.message);
                    this.authService.logout();
                    this.router.navigate(["auth/login"]);
                },
                (err) => {
                    this.landaService.alertError(
                        "Mohon Maaf",
                        err.error.errors
                    );
                }
            );
        } else {
            this.landaService.alertError(
                "Mohon Maaf",
                "Konfirmasi Password tidak sama"
            );
        }
    }
}
