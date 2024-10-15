
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ObtenerClientes } from '../interfaces/obtener_clientes.';
import { map, Observable } from 'rxjs';
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

  buscarClientePorNumeroDocumento(numeroDocumento: string) {
    return this.http.get<Clientes[]>(`${url}/clientes?numero_documento=${numeroDocumento}`);
  }

  // Obtener la cantidad de clientes registrados
  getCantidadClientesRegistrados(): Observable<number> {
    return this.getClientes().pipe(
      map(clientes => clientes.length)
    );
  }

  // Obtener la cantidad de clientes activos
  /// Obtener la cantidad de clientes activos

getCantidadClientesActivos(): Observable<number> {
  return this.http.get<{ clientes: any[] }>(`${url}/clientes`)
    .pipe(
      map(resp => resp.clientes.filter(cliente => cliente.estado === 'activo').length)
    );
}

}
