
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ObtenerClientes } from '../interfaces/obtener_clientes.';
import { map } from 'rxjs';

const url='http://localhost:8000/api';
@Injectable({
  providedIn: 'root'
})
export class ClientesService {

  constructor(private http: HttpClient) { }


  getClientes() {
    return this.http.get<ObtenerClientes>(`${url}/clientes`)
    .pipe(
      map(resp=>resp.clientes)
    );
  }
  
}
