// reserva.service.ts
import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ReservaService {
  private reservaSource = new BehaviorSubject<any>(null);
  reserva$ = this.reservaSource.asObservable();

  setReserva(reserva: any) {
    this.reservaSource.next(reserva);
  }
}
