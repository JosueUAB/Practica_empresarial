import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import Swal from 'sweetalert2';
import { WifiService } from '../service/wifi.service';
import { Wifi } from '../models/wifi.model';
import { Habitacion } from '../models/Habitaciones.models';
import { HabitacionService } from '../service/habitaciones.service';
import { FormBuilder } from '@angular/forms';





@Component({
  selector: 'app-reservas',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './reservas.component.html',
  styleUrl: './reservas.component.scss'
})
export class ReservasComponent {
  cargando: boolean = false;
  listaDeWifi: any = [];
  listadeHabitaciones: any = [];


  constructor(
    private fb: FormBuilder,
    private habitacionService: HabitacionService, //Inyecta el servicio de habitaciones
    private wifiService: WifiService // Inyecta el servicio de Wi-Fi
  ) {}

  ngOnInit(): void {
    this.getHabitaciones();
    this.getWifi(); // Obtener la lista de Wi-Fi
  }
  getWifi() {
    this.wifiService.getWifi().subscribe(
      (resp: Wifi[]) => {
        this.listaDeWifi = resp;
        console.log(this.listaDeWifi);
      },
      (error) => {
        console.error(error);

      }
    );
  }

  getHabitaciones() {
    this.cargando = true;
    this.habitacionService.getHabitaciones().subscribe(
      (resp) => {
        this.listadeHabitaciones = resp;
        console.log(this.listadeHabitaciones);
        this.cargando = false;
      },
      (error) => {
        console.error(error);
        this.cargando = false;
      }
    );
  }




}
