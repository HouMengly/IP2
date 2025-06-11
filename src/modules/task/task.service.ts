import { Injectable, NotFoundException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Task } from './task.entity';

@Injectable()
export class TaskService {
  tasks: any;
  constructor(
    @InjectRepository(Task)
    private tasksRepo: Repository<Task>,
  ) { }

  create(taskData: Partial<Task>) {
    const task = this.tasksRepo.create(taskData);
    return this.tasksRepo.save(task);
  }

  findAll() {
    return this.tasksRepo.find({
      select: ['id', 'name', 'description', 'completedAt'],
      relations: ['user'],
    });
  }

  async findOne(id: number) {
    const task = await this.tasksRepo.findOne({ 
      where: { id },
      relations: ['user'] 
    });
    
    if (!task) {
      throw new NotFoundException(`Task with id ${id} not found`);
    }
    return task;
  }
  
  async update(id: number, updateData: Partial<Task>) {
    await this.tasksRepo.update(id, updateData);
    return this.findOne(id);
  }

  remove(id: number) {
    return this.tasksRepo.delete(id);
  }

  async removeAll() {
    const tasks = await this.tasksRepo.find();
    if (tasks.length === 0) {
      return { message: 'No tasks to delete' };
    }
    await this.tasksRepo.clear();
    return { message: 'All tasks deleted successfully' };
  }
}