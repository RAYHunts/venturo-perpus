import {
    Component,
    EventEmitter,
    Input,
    OnInit,
    Output,
    SimpleChange,
} from "@angular/core";
import { LandaService } from "src/app/core/services/landa.service";
import { BorrowService } from "../../services/borrow.service";

@Component({
    selector: "form-borrow",
    templateUrl: "./form-borrow.component.html",
    styleUrls: ["./form-borrow.component.scss"],
})
export class FormBorrowComponent implements OnInit {
    books: [];
    users: [];
    @Input() borrowId: number;
    @Output() afterSave = new EventEmitter<boolean>();
    mode: string;

    formModel: {
        id: number;
        book_id: number;
        user_id: number;
    };

    constructor(
        private borrowService: BorrowService,
        private landaService: LandaService
    ) {}

    ngOnInit(): void {
        this.getBooks();
        this.getUsers();
    }

    emptyForm() {
        this.mode = "add";
        this.formModel = {
            id: 0,
            book_id: 0,
            user_id: 0,
        };
        if (this.borrowId > 0) {
            this.mode = "edit";
            this.getBorrow(this.borrowId);
        }
    }

    ngOnChanges(changes: SimpleChange) {
        this.emptyForm();
    }

    getBorrow(id: number) {
        this.borrowService.getBorrowById(id).subscribe((res: any) => {
            this.formModel = {
                id: res.data.id,
                book_id: res.data.book.id,
                user_id: res.data.user.id,
            };
        });
    }

    getUsers() {
        this.borrowService
            .getUsers({ not_admin: true })
            .subscribe((res: any) => {
                this.users = res.data.list;
            });
    }

    getBooks() {
        this.borrowService.getBooks().subscribe((res: any) => {
            this.books = res.data.list;
        });
    }

    save() {
        if (this.mode == "add") {
            this.borrowService.createBorrow(this.formModel).subscribe(
                (res: any) => {
                    this.landaService.alertSuccess("Berhasil", res.message);
                    this.afterSave.emit();
                },
                (err) => {
                    this.landaService.alertError(
                        "Mohon Maaf",
                        err.error.message
                    );
                }
            );
        } else {
            this.borrowService.updateBorrow(this.formModel).subscribe(
                (res: any) => {
                    this.landaService.alertSuccess("Berhasil", res.message);
                    this.afterSave.emit();
                },
                (err) => {
                    this.landaService.alertError(
                        "Mohon Maaf",
                        err.error.message
                    );
                }
            );
        }
    }

    back() {
        this.afterSave.emit();
    }
}
