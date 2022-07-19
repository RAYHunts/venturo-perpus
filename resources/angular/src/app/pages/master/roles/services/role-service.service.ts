import { Injectable } from "@angular/core";
import { LandaService } from "src/app/core/services/landa.service";

@Injectable({
    providedIn: "root",
})
export class RoleService {
    constructor(private landaService: LandaService) {}

    getRoles(arrParameter) {
        return this.landaService.DataGet("/v1/roles", arrParameter);
    }

    getRoleById(roleId) {
        return this.landaService.DataGet("/v1/roles/" + roleId);
    }

    createRole(payload) {
        return this.landaService.DataPost("/v1/roles", payload);
    }

    updateRole(payload) {
        return this.landaService.DataPut("/v1/roles", payload);
    }

    deleteRole(roleId) {
        return this.landaService.DataDelete("/v1/roles/" + roleId);
    }
}
