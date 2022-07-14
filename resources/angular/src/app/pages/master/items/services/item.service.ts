import { Injectable } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';

@Injectable({
    providedIn: 'root'
})
export class ItemService {

    constructor(private landaService: LandaService) { }

    getItems(arrParameter) {
        return this.landaService.DataGet('/v1/items', { arrParameter });
    }

    getItemById(itemId) {
        return this.landaService.DataGet('/v1/items/' + itemId);
    }

    createItem(payload) {
        return this.landaService.DataPost('/v1/items', payload);
    }

    updateItem(payload) {
        return this.landaService.DataPut('/v1/items', payload);
    }

    deleteItem(itemId) {
        return this.landaService.DataDelete('/v1/items/' + itemId);
    }
}
