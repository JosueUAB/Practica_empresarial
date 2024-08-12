
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ObtenerClientes } from '../interfaces/obtener_clientes.';
import { map } from 'rxjs';
import { Clientes } from '../models/Clientes.models';

const url='http://localhost:8000/api';
@Injectable({
  providedIn: 'root'
})
export class ClientesService {

  constructor(private http: HttpClient) { }
//crear cliente
crearCliente(clientes:any){
  return this.http.post<Clientes>(`${url}/clientes`,clientes)
}

  getClientes() {
    return this.http.get<ObtenerClientes>(`${url}/clientes`)
    .pipe(
      map(resp=>resp.clientes)
    );
  }

  //obtener detalles de cliente

  detallesCliente(id:string){
    return this.http.get(`${url}/clientes/${id}`);
  }

  //editar cliente

  editarCliente(cliente:any){
    return this.http.put(`${url}/clientes/${cliente.id}`,cliente);
  }

  //eliminar cliente
  eliminarCliente(id:string){
    return this.http.delete(`${url}/clientes/${id}`);
  }

  //buscar cliente

}
