import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RegistroHabitacionesComponent } from './registro-habitaciones.component';

describe('RegistroHabitacionesComponent', () => {
  let component: RegistroHabitacionesComponent;
  let fixture: ComponentFixture<RegistroHabitacionesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [RegistroHabitacionesComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(RegistroHabitacionesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
