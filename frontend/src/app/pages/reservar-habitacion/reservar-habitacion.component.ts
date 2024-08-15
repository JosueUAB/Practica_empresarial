import { Component } from '@angular/core';

import { ReservaService } from '../service/reserva.service';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { Clientes } from '../models/Clientes.models'; // Asegúrate de tener el modelo adecuado para Clientes
import { ClientesService } from '../service/cliente.service'; // Importa el servicio de clientes
import Swal from 'sweetalert2'; // Importa SweetAlert2 para notificaciones


@Component({
  selector: 'app-reservar-habitacion',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    ReactiveFormsModule
  ],
  templateUrl: './reservar-habitacion.component.html',
  styleUrl: './reservar-habitacion.component.scss'
})
export class ReservarHabitacionComponent {

  reserva: any;
  cargando: boolean = false;
  listadeClientes:any = [];

  validarFormulario: FormGroup = this.fb.group({
    nombre: ['', Validators.required],
    apellido: ['', Validators.required],
    numero_documento: ['', [Validators.required]],
    correo: ['', [Validators.required,]],
    direccion: ['', Validators.required],
    nacionalidad: ['', Validators.required],
    procedencia: ['', Validators.required],
    fecha_de_nacimiento: ['', Validators.required],
    estado_civil: ['', Validators.required],
    telefono: ['', [ ]],
    tipo_de_huesped: ['', Validators.required],
    tipo_de_documento: ['', Validators.required],
    id:['']
  });

  constructor(
    private fb:FormBuilder,
    private reservaService: ReservaService,  // Inject the service into the component

    private clientesService: ClientesService

  ) {
    this.getClientes();
  }


  ngOnInit(): void {
    this.reservaService.reserva$.subscribe(reserva => {
      this.reserva = reserva;
      console.log(`reservar habitacion ${this.reserva}`); // Utilizar la reserva recibida
    });
  }




  getClientes() {
    this.cargando = true;

    // Llamar al servicio para obtener la lista de clientes
    this.clientesService.getClientes().subscribe(
      (resp: Clientes[]) => {
        this.listadeClientes = resp;
        console.log(this.listadeClientes);
        this.cargando = false;
      },
      (error) => {
        console.error(error);
        this.cargando = false;
      }
    );
  }

  CerrarModalCrearCliente(){

  }
  crearCliente(){

  }
  crearReserva(){

  }




}
