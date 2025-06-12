import { Field, ID, ObjectType } from '@nestjs/graphql';

@ObjectType()
export class Hotel {
  @Field(() => ID)
  id: number;

  @Field()
  name: string;

  @Field()
  address: string;

  @Field()
  phone: string;
}