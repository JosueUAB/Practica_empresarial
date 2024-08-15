import { Routes } from '@angular/router';
import { LoginComponent } from './pages/login/login.component';
import { HabitacionesComponent } from './pages/habitaciones/habitaciones.component';
import { PanelComponent } from './pages/panel/panel.component';
import { ClientesComponent } from './pages/clientes/clientes.component';
import { WifiComponent } from './pages/wifi/wifi.component';
import { ReservasComponent } from './pages/reservas/reservas.component';
import { ReservarHabitacionComponent } from './pages/reservar-habitacion/reservar-habitacion.component';

export const routes: Routes = [

  { path: 'login', component: LoginComponent },
  { path: 'habitaciones', component: HabitacionesComponent },
  { path: 'wifi', component: WifiComponent },
  { path: 'panel', component: PanelComponent },
  { path: 'clientes', component: ClientesComponent },
  { path: 'hospedaje', component: ReservasComponent },
  { path: 'reservar_habitacion', component: ReservarHabitacionComponent },
  { path: '', redirectTo: 'login', pathMatch: 'full' },  // Ruta por defecto
  { path: '**', redirectTo: 'login' }  // Ruta de captura para redirigir a una ruta válida
];
