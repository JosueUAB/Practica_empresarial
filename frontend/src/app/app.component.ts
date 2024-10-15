import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { RouterModule, RouterOutlet } from '@angular/router';
import { LoginComponent } from "./pages/login/login.component";
import { SidebarComponent } from "./pages/sidebar/sidebar.component";
import { HomeComponent } from './pages/home/home.component';
import { NavbarComponent } from "./pages/navbar/navbar.component";
import { initFlowbite } from 'flowbite';
import { MatInputModule } from '@angular/material/input';


@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet,
    CommonModule,
    LoginComponent,
    RouterModule,
    SidebarComponent,
    MatInputModule,
    HomeComponent,
     NavbarComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss'
})
export class AppComponent {
  title = 'frontend';
  ngOnInit(): void {
    initFlowbite();
  }
}
