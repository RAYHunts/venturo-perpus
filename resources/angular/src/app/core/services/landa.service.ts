import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import Swal from 'sweetalert2';

import { environment } from '../../../environments/environment';

@Injectable({
    providedIn: 'root',
})
export class LandaService {
    apiURL = environment.apiURL;
    userToken: any;
    httpOptions: any;

    constructor(private http: HttpClient) {

    }

    ngOnInit(): void {}

    /**
     * Request GET
     */
    DataGet(path, payloads = {}) {
        return this.http.get(this.apiURL + path, {
            params: payloads,
        });
    }

    /**
     * Request POST
     */
    DataPost(path, payloads = {}) {
        const reqHeader = this.httpOptions;
        return this.http.post(this.apiURL + path, payloads, reqHeader);
    }

    /**
     * Request PUT
     */
     DataPut(path, payloads = {}) {
        const reqHeader = this.httpOptions;
        return this.http.put(this.apiURL + path, payloads, reqHeader);
    }

     /**
     * Request DELETE
     */
      DataDelete(path, payloads = {}) {
        return this.http.delete(this.apiURL + path, {
            params: payloads,
        });
    }

    /**
     * Sweet alert Sukses
     */
     alertSuccess(title, content, timer = 3.5) {
        Swal.fire({
            title,
            text: content,
            icon: 'success',
            timer: timer*1000,
            showConfirmButton: true,
        });
    }

    /**
     * Sweet alert warning
     */
    alertWarning(title, content, timer = 3.5) {
        Swal.fire({
            title,
            text: content,
            icon: 'warning',
            timer: timer*1000,
            showConfirmButton: true,
        });
    }

    /**
     * Sweet alert info
     */
     alertInfo(title, content, timer = 3.5) {
        Swal.fire({
            title,
            text: content,
            icon: 'info',
            timer: timer*1000,
            showConfirmButton: true,
        });
    }

    /**
     * Sweet alert error
     */
    alertError(title, content) {
        let isi = '';
        if (Array.isArray(content) === true) {
            content.forEach(function (element) {
                isi = isi + element + ' <br>';
            });
        } else {
            isi = String(content);
        }
        Swal.fire(title, isi, 'error');
    }

}