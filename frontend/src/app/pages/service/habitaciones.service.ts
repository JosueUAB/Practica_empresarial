import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Habitacion } from '../models/Habitaciones.models';
import { map } from 'rxjs/operators';
import { Wifi } from '../models/wifi.model';
import { Observable } from 'rxjs';

const url = 'http://localhost:8000/api';

@Injectable({
  providedIn: 'root'
})
export class HabitacionService {

  constructor(private http: HttpClient) { }

  // Crear habitación
  crearHabitacion(habitacion: Habitacion) {
    return this.http.post<Habitacion>(`${url}/habitaciones/`, habitacion);
  }

  // Obtener todas las habitaciones
  getHabitaciones() {
    return this.http.get<{ habitaciones: Habitacion[] }>(`${url}/habitaciones`)
      .pipe(
        map(resp => resp.habitaciones)
      );
  }

  // Obtener detalles de una habitación
  detallesHabitacion(id: string) {
    return this.http.get<Habitacion>(`${url}/habitaciones/${id}`);
  }

  // Editar habitación
  editarHabitacion(habitacion: any) {
    return this.http.put<Habitacion>(`${url}/habitaciones/${habitacion.id}`, habitacion);
  }

  // Eliminar habitación
  eliminarHabitacion(id: string) {
    return this.http.delete(`${url}/habitaciones/${id}`);
  }

  // Método para obtener la lista de Wi-Fi
  getWifi() {
    return this.http.get<{ wifi: Wifi[] }>(`${url}/wifi`)
      .pipe(
        map(resp => resp.wifi)
      );
  }

   // Obtener la cantidad de habitaciones disponibles
   getCantidadHabitacionesDisponibles(): Observable<number> {
    return this.http.get<{ habitaciones: any[] }>(`${url}/habitaciones`)
      .pipe(
        map(resp => resp.habitaciones.filter(h => h.estado === 'disponible').length)
      );
  }

}
