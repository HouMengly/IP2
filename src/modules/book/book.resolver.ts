import { Args, Mutation, Query, Resolver } from '@nestjs/graphql';
import { BookingService } from './book.service';


@Resolver('Booking')
export class BookingResolver {
  constructor(private readonly bookingService: BookingService) {}

  private readonly hotels = [
    {
      id: '1',
      name: 'Hotel1',
      address: 'Address1',
      phone: '012 445 353'
    }
  ]

  @Query('bookings')
  getBookings(
    @Args('startDate') startDate: string,
    @Args('endDate') endDate: string,
  ) {
    return this.bookingService.findAll(startDate, endDate);
  }

  @Mutation('bookHotel')
  bookHotel(
    @Args('hotel_id') hotel_id: number,
    @Args('start_date') start_date: string,
    @Args('end_date') end_date: string,
    @Args('price') price: number,
  ) {
    return this.bookingService.create(hotel_id, start_date, end_date, price);
  }

  @Mutation('cancelBooking')
  cancelBooking(@Args('id') id: string) {
    return this.bookingService.cancel(Number(id));
  }

  @Mutation('checkIn')
  checkIn(@Args('id') id: string) {
    return this.bookingService.checkIn(Number(id));
  }
}