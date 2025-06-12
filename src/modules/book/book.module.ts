// src/modules/booking/booking.module.ts
import { Module } from '@nestjs/common';
import { BookingResolver } from './book.resolver';
import { BookingService } from './book.service';
import { HotelService } from '../hotel/hotel.service';

@Module({
  providers: [BookingResolver, BookingService, HotelService],
})
export class BookingModule {}