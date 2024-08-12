import { Routes } from '@angular/router';
import { LoginComponent } from './pages/login/login.component';
import { HabitacionesComponent } from './pages/habitaciones/habitaciones.component';
import { PanelComponent } from './pages/panel/panel.component';
import { ClientesComponent } from './pages/clientes/clientes.component';
import { RegistroHabitacionesComponent } from './pages/habitaciones/registro-habitaciones/registro-habitaciones.component';

export const routes: Routes = [
 {path:'login',component:LoginComponent},
 {path:'habitaciones',component:HabitacionesComponent,
  //rutas hijas
  children:[
    {path:'',component:HabitacionesComponent},
    {path:'nueva',component:RegistroHabitacionesComponent},
    {path:'editar/:id',component:HabitacionesComponent}
  ]
 },
 {path:'panel',component:PanelComponent},
  {path:'clientes',component:ClientesComponent}
];
