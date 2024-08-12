import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-habitaciones',
  standalone: true,
  imports: [CommonModule,
            RouterModule
  ],
  templateUrl: './habitaciones.component.html',
  styleUrl: './habitaciones.component.scss'
})
export class HabitacionesComponent  {
  habitaciones = [
    // Ejemplo de datos de habitaciones
    { numero: 101, estado: 'disponible', descripcion: 'Habitación con vista al mar', wifi: true, baño: true, ducha: true, tv: true, costo: 120 },
    // Agrega más habitaciones aquí
  ];
  pagina = 1;
  totalPaginas = Math.ceil(this.habitaciones.length / 10);

  constructor() {}

  ngOnInit(): void {}

  seleccionarHabitacion(habitacion: any): void {
    // Redirigir a otro componente o manejar la selección de la habitación
  }

  cambiarPagina(nuevaPagina: number): void {
    if (nuevaPagina > 0 && nuevaPagina <= this.totalPaginas) {
      this.pagina = nuevaPagina;
      // Lógica para cambiar de página
    }
  }
}
