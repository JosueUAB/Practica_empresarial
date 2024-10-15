import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { Reservas } from '../models/ReservarHabitaciones.model';

const url = 'http://localhost:8000/api/reservas';

@Injectable({
  providedIn: 'root'
})
export class ReservarhabitacionService {

  constructor(private http: HttpClient) { }

  // Crear una nueva reserva
  crearReserva(reserva: Reservas): Observable<Reservas> {
    return this.http.post<Reservas>(url, reserva);
  }

  // Obtener todas las reservas
  getReservas(): Observable<Reservas[]> {
    return this.http.get<{ reservas: Reservas[] }>(url)
      .pipe(
        map(response => response.reservas)
      );
  }

  // Obtener detalles de una reserva por ID
  getReservaPorId(id: string): Observable<Reservas> {
    return this.http.get<Reservas>(`${url}/${id}`);
  }
  

  // Actualizar una reserva existente
  actualizarReserva(id: string, reserva: Reservas): Observable<Reservas> {
    return this.http.put<Reservas>(`${url}/${id}`, reserva);
  }

  // Eliminar una reserva por ID
  eliminarReserva(id: string): Observable<void> {
    return this.http.delete<void>(`${url}/${id}`);
  }

}
