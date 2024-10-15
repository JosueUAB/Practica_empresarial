import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { HabitacionService } from '../service/habitaciones.service';
import { ClientesService } from '../service/cliente.service';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-panel',
  standalone: true,
  imports: [
            CommonModule,
            RouterModule
  ],
  templateUrl: './panel.component.html',
  styleUrl: './panel.component.scss'
})
export class PanelComponent {
  cantidadHabitacionesDisponibles: number = 0;
  cantidadClientes: number = 0;
  cantidadClientesActivos: number = 0;
  constructor(
    private habitacionService: HabitacionService,
    private clientesService: ClientesService  // Asegúrate de tener este método en el servicio
  ){}





  ngOnInit(): void {
    this.habitacionService.getCantidadHabitacionesDisponibles().subscribe(cantidad => {
      this.cantidadHabitacionesDisponibles = cantidad;
    });

    this.clientesService.getCantidadClientesRegistrados().subscribe(cantidad => {
      this.cantidadClientes = cantidad;
    });

    this.clientesService.getCantidadClientesActivos().subscribe(cantidad => {
      this.cantidadClientesActivos = cantidad;
    });


  }
}
