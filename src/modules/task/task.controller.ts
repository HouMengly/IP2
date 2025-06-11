import {
  Body,
  Controller,
  Delete,
  Get,
  Param,
  Post,
  Put,
  UsePipes,
  ValidationPipe,
} from '@nestjs/common';
import { Task } from './task.entity';
import { TaskService } from './task.service';
import { CreateTaskDto } from './dto/create-task.dto';
import { UpdateTaskDto } from './dto/update-task.dto';
import { CreateUserDto } from '../user/dto/create-user.dto';

@Controller('tasks')
export class TasksController {
  constructor(private readonly taskService: TaskService) { }

  @Post()
  @UsePipes(new ValidationPipe({ whitelist: true }))
  create(@Body() createTaskDto: CreateTaskDto) {
    return this.taskService.create(createTaskDto);
  }

  // @Post('create')
  // create(@Body() taskData: Partial<Task>) {
  //   return this.taskService.create(taskData);
  // }

  @Put(':id')
  @UsePipes(new ValidationPipe({ whitelist: true, forbidNonWhitelisted: true }))
  async update(@Param('id') id: string, @Body() updateTaskDto: UpdateTaskDto) {
    return this.taskService.update(+id, updateTaskDto);
  }

  // @Put(':id')
  // update(@Param('id') id: string, @Body() updateData: Partial<Task>) {
  //   return this.taskService.update(+id, updateData);
  // }

  @Get()
  findAll() {
    return this.taskService.findAll();
  }

  @Get(':id')
  findOne(@Param('id') id: string) {
    return this.taskService.findOne(+id);
  }

  @Delete(':id')
  remove(@Param('id') id: string) {
    return this.taskService.remove(+id);
  }

  @Delete()
  removeAll() {
    return this.taskService.removeAll();
  }
}