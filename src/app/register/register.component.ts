import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { UserService } from './user.service';
import { HttpClientModule } from '@angular/common/http';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-register',
  standalone: true,
  templateUrl: './register.component.html',
  styleUrl: './register.component.scss',
  providers: [UserService],
  imports: [
    FormsModule, 
    HttpClientModule, 
    CommonModule
  ]
})
export class RegisterComponent {
  users: any[] = [];
  newUser: any = { username: '', email: '', password: '' };
  selectedUser: any = null;

  constructor(private userService: UserService) { }

  ngOnInit(): void {
    this.loadUsers();
  }

  loadUsers() {
    this.userService.getUsers().subscribe(data => {
      this.users = data;
    });
  }

  createUser() {
    this.userService.createUser(this.newUser).subscribe(response => {
      alert('Dados salvos com sucesso!');
      this.loadUsers();
      this.newUser = { username: '', email: '', password: '' };
    });
  }

  updateUser(user: any) {
    this.userService.updateUser(user).subscribe(response => {
      alert('Item atualizado com sucesso!');
      this.loadUsers();
      this.clearSelection();
    });
  }

  deleteUser(id: number) {
    this.userService.deleteUser(id).subscribe(response => {
      alert('Item deletado com sucesso!');
      this.loadUsers();
    });
  }

  selectUser(user: any) {
    this.selectedUser = { ...user };
  }

  clearSelection() {
    this.selectedUser = null;
  }
}
