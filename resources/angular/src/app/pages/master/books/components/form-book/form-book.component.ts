import {
    Component,
    EventEmitter,
    Input,
    OnInit,
    Output,
    SimpleChange,
} from "@angular/core";
import { LandaService } from "src/app/core/services/landa.service";
import { BookService } from "../../services/book.service";

@Component({
    selector: "book-form",
    templateUrl: "./form-book.component.html",
    styleUrls: ["./form-book.component.scss"],
})
export class FormBookComponent implements OnInit {
    @Input() bookId: number;
    @Output() afterSave = new EventEmitter<boolean>();
    mode: string;
    formModel: {
        id: number;
        name: string;
        title: string;
        description: string;
        author: string;
        publisher: string;
        publish_year: number;
        photo: string;
        qty: number;
    };
    constructor(
        private bookService: BookService,
        private landaService: LandaService
    ) {}

    ngOnInit(): void {}

    emptyForm() {
        this.mode = "add";
        this.formModel = {
            id: 0,
            name: "",
            title: "",
            description: "",
            author: "",
            publisher: "",
            publish_year: null,
            photo: null,
            qty: 0,
        };
        if (this.bookId > 0) {
            this.mode = "edit";
            this.getBook(this.bookId);
        }
    }

    ngOnChanges(changes: SimpleChange) {
        this.emptyForm();
    }

    save() {
        if (this.mode == "add") {
            this.bookService.createBook(this.formModel).subscribe(
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
            this.bookService.updateBook(this.formModel).subscribe(
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

    getBook(id) {
        this.bookService.getBookById(id).subscribe(
            (res: any) => {
                this.formModel = res.data;
            },
            (err) => {
                console.log(err);
            }
        );
    }

    back() {
        this.afterSave.emit();
    }
}
