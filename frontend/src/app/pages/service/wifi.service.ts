import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Wifi } from '../models/wifi.model';
import { map } from 'rxjs/operators';

const url = 'http://localhost:8000/api';

@Injectable({
  providedIn: 'root'
})
export class WifiService {

  constructor(private http: HttpClient) { }

  // Crear red Wi-Fi
  crearWifi(wifi: Wifi) {
    return this.http.post<Wifi>(`${url}/wifi`, wifi);
  }

  // Obtener todas las redes Wi-Fi
  getWifi() {
    return this.http.get<{ wifi: Wifi[] }>(`${url}/wifi`)
      .pipe(
        map(resp => resp.wifi)
      );
  }

  // Obtener detalles de una red Wi-Fi
  detallesWifi(id: string) {
    return this.http.get<Wifi>(`${url}/wifi/${id}`);
  }

  // Editar red Wi-Fi
  editarWifi(wifi:any) {
    return this.http.put<Wifi>(`${url}/wifi/${wifi.id}`, wifi);
  }

  // Eliminar red Wi-Fi
  eliminarWifi(id: string) {
    return this.http.delete(`${url}/wifi/${id}`);
  }
}
