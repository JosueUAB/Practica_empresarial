import { Routes } from '@angular/router';
import { LoginComponent } from './pages/login/login.component';
import { HabitacionesComponent } from './pages/habitaciones/habitaciones.component';
import { PanelComponent } from './pages/panel/panel.component';
import { ClientesComponent } from './pages/clientes/clientes.component';

export const routes: Routes = [
 {path:'login',component:LoginComponent},
 {path:'habitaciones',component:HabitacionesComponent},
 {path:'panel',component:PanelComponent},
  {path:'clientes',component:ClientesComponent}
];
