// reserva.service.ts
import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ReservaService {
  private reservaSource = new BehaviorSubject<{ valor1: any, valor2: any } | null>(null);
  reserva$ = this.reservaSource.asObservable();

  setReserva(valor1: any, valor2: any) {
    this.reservaSource.next({ valor1, valor2 });
  }
}
