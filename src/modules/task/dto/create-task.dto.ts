import { IsNotEmpty, IsOptional, IsString, IsInt } from 'class-validator';

export class CreateTaskDto {
  @IsNotEmpty({ message: 'Task name is required' })
  @IsString({ message: 'Task name must be a string' })
  name: string;

  @IsOptional()
  @IsString({ message: 'Description must be a string' })
  description?: string;

  @IsNotEmpty({ message: 'User ID is required' })
  @IsInt({ message: 'User ID must be an integer' })
  userId: number;
}