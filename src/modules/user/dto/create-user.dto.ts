import { IsEmail, IsNotEmpty, MinLength } from 'class-validator';

export class CreateUserDto {
  @IsNotEmpty({ message: 'Username is required' })
  username: string;

  @IsNotEmpty({ message: 'Email is required' })
  @IsEmail()
  email: string;

  @IsNotEmpty({ message: 'Password is required' })
  @MinLength(3, { message: 'Password must be at least 3 characters long' })
  password: string;
}