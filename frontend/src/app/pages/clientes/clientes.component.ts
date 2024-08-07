import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms'; // Importa las clases necesarias para formularios
import { Clientes } from '../models/Clientes.models'; // Asegúrate de tener el modelo adecuado para Clientes
import { ClientesService } from '../service/cliente.service'; // Importa el servicio de clientes
import Swal from 'sweetalert2'; // Importa SweetAlert2 para notificaciones
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-clientes',
  standalone: true,
  imports: [CommonModule],
  templateUrl: 'Clientes.component.html',
  styleUrls: ['./clientes.component.css'], // Asegúrate de que sea styleUrls en plural
})
export class ClientesComponent implements OnInit {
  cargando: boolean = false;
  listadeClientes:any = []; // Utiliza el tipo adecuado para la lista de clientes
  validarFormulario: FormGroup; // Formulario reactivo para gestionar la creación de clientes

  // Inyectar el servicio ClientesService y FormBuilder en el constructor
  constructor(private fb: FormBuilder, private clientesService: ClientesService) {
    // Inicializar el formulario reactivo con validaciones
    this.validarFormulario = this.fb.group({
      nombre: ['', Validators.required],
      apellido: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      telefono: ['', Validators.required],
      direccion: [''],
    });

    this.getClientes(); // Llamar a getClientes para obtener la lista de clientes al crear el componente
  }

  ngOnInit(): void {}



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
}
