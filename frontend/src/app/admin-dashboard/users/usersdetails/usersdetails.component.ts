import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { UserService } from '../../../services/user.service';
import { User } from '../../../models/user';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-usersdetails',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './usersdetails.component.html',
  styleUrl: './usersdetails.component.css'
})
export class UsersdetailsComponent {
  user: User | undefined;

  constructor(private route: ActivatedRoute, private userService: UserService) {}

  ngOnInit(): void {
    const userId = this.route.snapshot.paramMap.get('id');
    if (userId) {
      this.userService.getUserById(+userId).subscribe(
        (response:any) => {
          this.user = response.data;
        },
        (error) => {
          console.error('Error fetching user details', error);
        }
      );
    }
  }
}