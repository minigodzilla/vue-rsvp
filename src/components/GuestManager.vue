<template>
	<div class="book">
		<div class="step-1  spread spread-welcome" :class="{ active: step == 1, complete: guest.hasOwnProperty('accepts') && guest.accepts != '', passed: step > 1 }">
			<div class="page right">
				<img draggable="false" class="img img-small img-flourish" src="/assets/flourish-1.jpg" />
				<div class="body-text">
					<h4>Greetings {{ guest.firstName }}!</h4>
					<p>Can you attend our wedding celebration?</p>
					<div class="input-row">
						<input type="radio" name="accepts" value="yes" id="accepts-yes" v-model="guest.accepts" />
						<label for="accepts-yes">Yes</label>
						<input type="radio" name="accepts" value="no" id="accepts-no" v-model="guest.accepts" />
						<label for="accepts-no">No</label>
					</div>
					<p style="font-size: 0.75em; line-height: 1.75"><strong>Sunday, September 5, 2021 at 4:30 PM</strong><br />Enoch Turner Schoolhouse Museum<br />106 Trinity Street, Toronto</p>
				</div>
				<img draggable="false" class="img img-small img-flourish" src="/assets/flourish-2.jpg" />
				<button class="page-turn" v-on:click="spreadWelcomeNext()">
					<img draggable="false" src="/assets/page-turn.svg" />
				</button>
				<div class="page-turn-tip" v-on:click="spreadWelcomeNext()">Turn the page to continue.</div>
			</div>
		</div>
		<div class="step-2  spread spread-guest-and-children" v-if="guest.accepts == 'yes'" :class="{ active: step == 2, complete: guest.hasOwnProperty('hasChildren') && guest.hasChildren != '', passed: step > 2 }">
			<div class="page left" v-on:click="prev()">
				<img draggable="false" class="img img-full" src="/assets/guests-and-children.jpg" />
			</div>
			<div class="page right">
				<div class="body-text">
					<h4>Will you be bringing a guest?</h4>
					<div class="input-row">
						<input type="radio" name="has-guest" value="no" id="has-guest-no" v-model="guest.hasGuest" />
						<label for="has-guest-no">No</label>
						<input type="radio" name="has-guest" value="yes" id="has-guest-yes" v-model="guest.hasGuest" />
						<label for="has-guest-yes">Yes</label>
					</div>
				</div>
				<div class="body-text" :class="{ hidden: guest.hasGuest == '', shown: guest.hasGuest != '' }">
					<h4>Will you be bringing children?</h4>
					<div class="input-row">
						<input type="radio" name="has-children" value="no" id="has-children-no" v-model="guest.hasChildren" />
						<label for="has-children-no">None</label>
						<input type="radio" name="has-children" value="one" id="has-children-one" v-model="guest.hasChildren" />
						<label for="has-children-one">One</label>
						<input type="radio" name="has-children" value="two" id="has-children-two" v-model="guest.hasChildren" />
						<label for="has-children-two">Two</label>
					</div>
				</div>
				<button class="page-turn" v-on:click="next()">
					<img draggable="false" src="/assets/page-turn.svg" />
				</button>
				<div class="page-turn-tip" v-on:click="next()">Turn the page to continue.</div>
			</div>
		</div>
		<div class="step-3  spread spread-meal" v-if="guest.accepts == 'yes'" :class="{ active: step == 3, complete: guest.hasOwnProperty('meal') && guest.meal != '', passed: step > 3 }">
			<div class="page left" v-on:click="prev()">
				<img draggable="false" class="img img-full" src="/assets/beatrix-1.jpg" />
			</div>
			<div class="page right">
				<div class="body-text">
					<h4>What is your meal preference?</h4>
					<div class="input-row">
						<input type="radio" name="meal" value="veg" id="meal-veg" v-model="guest.meal" />
						<label for="meal-veg">Vegetarian</label>
						<input type="radio" name="meal" value="beef" id="meal-beef" v-model="guest.meal" />
						<label for="meal-beef">Beef</label>
						<input type="radio" name="meal" value="chicken" id="meal-chicken" v-model="guest.meal" />
						<label for="meal-chicken">Chicken</label>
					</div>
				</div>
				<div class="body-text" :class="{ hidden: guest.meal == '', shown: guest.meal != '' }">
					<h4>Any dietary notes? (allergies, restrictions, etc.?)</h4>
					<div class="input-row">
						<textarea spellcheck="false" v-model="guest.dietaryNotes"></textarea>
					</div>
				</div>
				<button class="page-turn" v-on:click="next()">
					<img draggable="false" src="/assets/page-turn.svg" />
				</button>
				<div class="page-turn-tip" v-on:click="next()">Turn the page to continue.</div>
			</div>
		</div>
		<div class="step-4  spread spread-alcohol" v-if="guest.accepts == 'yes'" :class="{ active: step == 4, complete: guest.hasOwnProperty('alcoholPref') && guest.alcoholPref != '', passed: step > 4 }">
			<div class="page left" v-on:click="prev()">
				<img draggable="false" class="img img-full" src="/assets/alcohol.jpg" />
			</div>
			<div class="page right">
				<div class="body-text">
					<h4>What is your preference for alcoholic drinks?</h4>
					<div class="input-row">
						<input type="radio" name="alcohol" value="none" id="alcohol-none" v-model="guest.alcoholPref" />
						<label for="alcohol-none">None</label>
						<input type="radio" name="alcohol" value="beer" id="alcohol-beer" v-model="guest.alcoholPref" />
						<label for="alcohol-beer">Beer</label>
						<input type="radio" name="alcohol" value="wine" id="alcohol-wine" v-model="guest.alcoholPref" />
						<label for="alcohol-wine">Wine</label>
					</div>
				</div>
				<button class="page-turn" v-on:click="spreadAlcoholNext()">
					<img draggable="false" src="/assets/page-turn.svg" />
				</button>
				<div class="page-turn-tip" v-on:click="spreadAlcoholNext()">Turn the page to continue.</div>
			</div>
		</div>
		<div class="step-5  spread spread-guest-name" v-if="guest.hasGuest == 'yes'" :class="{ active: step == 5, complete: guest.hasOwnProperty('guestFirstName') && guest.guestFirstName != '', passed: step > 5 }">
			<div class="page left" v-on:click="prev()">
				<img draggable="false" class="img img-full" src="/assets/guest-name.jpg" />
			</div>
			<div class="page right">
				<div class="body-text">
					<h4>What is your guest's first name?</h4>
					<div class="input-row">
						<input type="text" name="guest-first-name" id="guest-first-name" v-model="guest.guestFirstName" />
					</div>
				</div>
				<div class="body-text" :class="{ hidden: guest.guestFirstName == '', shown: guest.guestFirstName != '' }">
					<h4>What is their last name?</h4>
					<div class="input-row">
						<input type="text" name="guest-last-name" id="guest-last-name" v-model="guest.guestLastName" />
					</div>
				</div>
				<button class="page-turn" v-on:click="next()">
					<img draggable="false" src="/assets/page-turn.svg" />
				</button>
				<div class="page-turn-tip" v-on:click="next()">Turn the page to continue.</div>
			</div>
		</div>
		<div class="step-6  spread spread-guest-meal" v-if="guest.hasGuest == 'yes'" :class="{ active: step == 6, complete: guest.hasOwnProperty('guestMeal') && guest.guestMeal != '', passed: step > 6 }">
			<div class="page left" v-on:click="prev()">
				<img draggable="false" class="img img-full" src="/assets/guest-meal.jpg" />
			</div>
			<div class="page right">
				<div class="body-text">
					<h4>What is {{ guest.guestFirstName }}'s meal preference?</h4>
					<div class="input-row">
						<input type="radio" name="guest-meal" value="veg" id="guest-meal-veg" v-model="guest.guestMeal" />
						<label for="guest-meal-veg">Vegetarian</label>
						<input type="radio" name="guest-meal" value="beef" id="guest-meal-beef" v-model="guest.guestMeal" />
						<label for="guest-meal-beef">Beef</label>
						<input type="radio" name="guest-meal" value="chicken" id="guest-meal-chicken" v-model="guest.guestMeal" />
						<label for="guest-meal-chicken">Chicken</label>
					</div>
				</div>
				<div class="body-text" :class="{ hidden: guest.guestMeal == '', shown: guest.guestMeal != '' }">
					<h4>Any dietary notes? (allergies, restrictions, etc.?)</h4>
					<div class="input-row">
						<textarea spellcheck="false" v-model="guest.guestDietaryNotes"></textarea>
					</div>
				</div>
				<button class="page-turn" v-on:click="next()">
					<img draggable="false" src="/assets/page-turn.svg" />
				</button>
				<div class="page-turn-tip" v-on:click="next()">Turn the page to continue.</div>
			</div>
		</div>
		<div class="step-7  spread spread-guest-alcohol" v-if="guest.hasGuest == 'yes'" :class="{ active: step == 7, complete: guest.hasOwnProperty('guestAlcoholPref') && guest.guestAlcoholPref != '', passed: step > 7 }">
			<div class="page left" v-on:click="prev()">
				<img draggable="false" class="img img-full" src="/assets/guest-alcohol.jpg" />
			</div>
			<div class="page right">
				<div class="body-text">
					<h4>What is {{ guest.guestFirstName }}'s preference for alcoholic drinks?</h4>
					<div class="input-row">
						<input type="radio" name="guest-alcohol" value="none" id="guest-alcohol-none" v-model="guest.guestAlcoholPref" />
						<label for="guest-alcohol-none">None</label>
						<input type="radio" name="guest-alcohol" value="beer" id="guest-alcohol-beer" v-model="guest.guestAlcoholPref" />
						<label for="guest-alcohol-beer">Beer</label>
						<input type="radio" name="guest-alcohol" value="wine" id="guest-alcohol-wine" v-model="guest.guestAlcoholPref" />
						<label for="guest-alcohol-wine">Wine</label>
					</div>
				</div>
				<button class="page-turn" v-on:click="spreadGuestAlcoholNext()">
					<img draggable="false" src="/assets/page-turn.svg" />
				</button>
				<div class="page-turn-tip" v-on:click="spreadGuestAlcoholNext()">Turn the page to continue.</div>
			</div>
		</div>
		<div class="step-8  spread spread-child-1-name" v-if="guest.hasChildren == 'one' || guest.hasChildren == 'two'" :class="{ active: step == 8, complete: guest.hasOwnProperty('child1FirstName') && guest.child1FirstName != '', passed: step > 8 }">
			<div class="page left" v-on:click="spreadChild1NamePrev()">
				<img draggable="false" class="img img-full" src="/assets/child-1-name.jpg" />
			</div>
			<div class="page right">
				<div class="body-text">
					<h4 v-if="this.guest.hasChildren == 'one'">What is your child's first name?</h4>
					<h4 v-else>What is one child's first name?</h4>
					<div class="input-row">
						<input type="text" name="child-1-first-name" id="child-1-first-name" v-model="guest.child1FirstName" />
					</div>
				</div>
				<button class="page-turn" v-on:click="next()">
					<img draggable="false" src="/assets/page-turn.svg" />
				</button>
				<div class="page-turn-tip" v-on:click="next()">Turn the page to continue.</div>
			</div>
		</div>
		<div class="step-9  spread spread-child-1-meal" v-if="guest.hasChildren == 'one' || guest.hasChildren == 'two'" :class="{ active: step == 9, complete: guest.hasOwnProperty('child1Meal') && guest.child1Meal != '', passed: step > 9 }">
			<div class="page left" v-on:click="prev()">
				<img draggable="false" class="img img-full" src="/assets/child-1-meal.jpg" />
			</div>
			<div class="page right">
				<div class="body-text">
					<h4>What is {{ guest.child1FirstName }}'s meal preference?</h4>
					<div class="input-row">
						<input type="radio" name="child-1-meal" value="veg" id="child-1-meal-veg" v-model="guest.child1Meal" />
						<label for="child-1-meal-veg">Vegetarian</label>
						<input type="radio" name="child-1-meal" value="non-veg" id="child-1-meal-non-veg" v-model="guest.child1Meal" />
						<label for="child-1-meal-non-veg">Non-Vegetarian</label>
						<input type="radio" name="child-1-meal" value="none" id="child-1-meal-none" v-model="guest.child1Meal" />
						<label for="child-1-meal-none">Bringing our own</label>
					</div>
				</div>
				<div class="body-text" :class="{ hidden: guest.child1Meal == '' || guest.child1Meal == 'none', shown: guest.child1Meal != '' && guest.child1Meal != 'none' }">
					<h4>Any dietary notes? (allergies, restrictions, etc.?)</h4>
					<p>
						<em>Please write anything you need in here,<br />we'll take care of it!</em>
					</p>
					<div class="input-row">
						<textarea spellcheck="false" v-model="guest.child1DietaryNotes"></textarea>
					</div>
				</div>
				<button class="page-turn" v-on:click="spreadChild1MealNext()">
					<img draggable="false" src="/assets/page-turn.svg" />
				</button>
				<div class="page-turn-tip" v-on:click="spreadChild1MealNext()">Turn the page to continue.</div>
			</div>
		</div>
		<div class="step-10 spread spread-child-2-name" v-if="guest.hasChildren == 'two'" :class="{ active: step == 10, complete: guest.hasOwnProperty('child2FirstName') && guest.child2FirstName != '', passed: step > 10 }">
			<div class="page left" v-on:click="prev()">
				<img draggable="false" class="img img-full" src="/assets/child-2-name.jpg" />
			</div>
			<div class="page right">
				<div class="body-text">
					<h4>What is the other child's first name?</h4>
					<div class="input-row">
						<input type="text" name="child-2-first-name" id="child-2-first-name" v-model="guest.child2FirstName" />
					</div>
				</div>
				<button class="page-turn" v-on:click="next()">
					<img draggable="false" src="/assets/page-turn.svg" />
				</button>
				<div class="page-turn-tip" v-on:click="next()">Turn the page to continue.</div>
			</div>
		</div>
		<div class="step-11 spread spread-child-2-meal" v-if="guest.hasChildren == 'two'" :class="{ active: step == 11, complete: guest.hasOwnProperty('child2Meal') && guest.child2Meal != '', passed: step > 11 }">
			<div class="page left" v-on:click="prev()">
				<img draggable="false" class="img img-full" src="/assets/child-2-meal.jpg" />
			</div>
			<div class="page right">
				<div class="body-text">
					<h4>What is {{ guest.child2FirstName }}'s meal preference?</h4>
					<div class="input-row">
						<input type="radio" name="child-2-meal" value="veg" id="child-2-meal-veg" v-model="guest.child2Meal" />
						<label for="child-2-meal-veg">Vegetarian</label>
						<input type="radio" name="child-2-meal" value="non-veg" id="child-2-meal-non-veg" v-model="guest.child2Meal" />
						<label for="child-2-meal-non-veg">Non-Vegetarian</label>
						<input type="radio" name="child-2-meal" value="none" id="child-2-meal-none" v-model="guest.child2Meal" />
						<label for="child-2-meal-none">Bringing our own</label>
					</div>
				</div>
				<div class="body-text" :class="{ hidden: guest.child2Meal == '' || guest.child2Meal == 'none', shown: guest.child2Meal != '' && guest.child2Meal != 'none' }">
					<h4>Any dietary notes? (allergies, restrictions, etc.?)</h4>
					<p>
						<em>Please write anything you need in here,<br />we'll take care of it!</em>
					</p>
					<div class="input-row">
						<textarea spellcheck="false" v-model="guest.child2DietaryNotes"></textarea>
					</div>
				</div>
				<button class="page-turn" v-on:click="modifyGuest()">
					<img draggable="false" src="/assets/page-turn.svg" />
				</button>
				<div class="page-turn-tip" v-on:click="modifyGuest()">Turn the page to continue.</div>
			</div>
		</div>
		<div class="step-12 spread spread-thank-you" :class="{ active: step == 12 }">
			<div class="page left" v-on:click="spreadThankYouPrev()">
				<img v-if="guest.accepts == 'yes'" draggable="false" class="img img-full" src="/assets/birds.jpg" />
				<img v-else draggable="false" class="img img-full" src="/assets/cannot-attend.jpg" />
			</div>
			<div class="page right">
				<img draggable="false" class="img img-small img-flourish" src="/assets/flourish-1.jpg" />
				<div class="body-text">
					<h3>Thank you!</h3>
					<p>We have your RSVP.</p>
					<p>You may return at any time to make changes.</p>
					<p v-if="guest.accepts == 'yes'">We can't wait to see you!</p>
					<div v-else>
						<p>We're sorry that you're unable to attend.</p>
						<p>We can't wait to see you next time!</p>
					</div>
				</div>
				<img draggable="false" class="img img-small img-flourish" src="/assets/flourish-2.jpg" />
			</div>
		</div>
	</div>
</template>

<style lang="scss">
.overlay {
	opacity: 0;
	pointer-events: none;
	position: absolute;
	z-index: 10;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	background-color: rgba(0, 0, 0, 0.75);
	color: #9c8264;

	svg {
		width: 25vw;
		fill: #9c8264;
		margin-bottom: 1em;
	}
}
.book {
	transition: filter 200ms ease;
	// filter: blur(2em);
	position: relative;
	background: #393617;
	width: 85vw;
	height: 50vw;
	perspective: 200vw;
	border-radius: 0.5vw;
	box-shadow: 1.5vw 0.75vw 2vw #000, inset 0.125vw 0.125vw 0.1vw #757154, inset -0.125vw -0.125vw 0.1vw #0e0a07, inset -1vw -1vw 2vw rgba(0, 0, 0, 0.5);

	&::before {
		content: '';
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		background-image: url('/assets/leather.jpg');
		background-size: 15vw;
		mix-blend-mode: soft-light;
		border-radius: 0.5vw;
	}

	.spread {
		position: absolute;
		z-index: 1;
		top: 1vw;
		right: 1vw;
		bottom: 1vw;
		left: 1vw;
		transition: z-index 2s cubic-bezier(0.645, 0.045, 0.355, 1);

		.page {
			backface-visibility: hidden;
			position: absolute;
			top: 0;
			bottom: 0;
			width: 50%;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			transform: rotateY(0deg);
			transform-origin: 0% 0%;
			filter: brightness(0.9) contrast(1.1);
			transition-property: transform, filter, clip-path;
			transition-delay: 0s;
			transition-duration: 2s;
			transition-timing-function: cubic-bezier(0.645, 0.045, 0.355, 1);

			&.left {
				left: 0;
				background-image: linear-gradient(to left, #8f7c5f 0%, #ae9776 12.5%, #bea683 50%, #bea684 100%);
				transform-origin: 100% 0;
				transform: rotateY(180deg);
				z-index: 1;
			}

			&.right {
				right: 0;
				background-image: linear-gradient(to right, #a89373 0%, #c1aa87 1%, #c0a885 12.5%, #a28c6c 50%, #a58e6e 100%);
				clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 100% 100%, 0% 100%);
			}

			> div,
			> img {
				user-select: none;
			}

			> div,
			> img,
			> input,
			> button {
				mix-blend-mode: multiply;
			}

			button {
				width: 25%;
				margin: 0;
				padding: 0;
				border: 0 none;
				background: transparent;
			}

			.img-small {
				display: block;
				margin: 0 auto;
				width: 100%;
			}

			.img-flourish {
				width: 30%;
				margin: 1em 0;
			}

			.img-full {
				max-height: 85%;
				max-width: 90%;
			}

			@keyframes reveal-form-field {
				0% {
					max-height: 0;
					opacity: 0;
				}
				50% {
					max-height: 12.5em;
					opacity: 0;
				}
				100% {
					max-height: 12.5em;
					opacity: 1;
				}
			}

			.body-text {
				max-width: 35vw;
				text-align: center;
				margin: 1em 0;

				h4 {
					margin-top: 0;
					margin-bottom: 1em;
				}

				.input-row {
					line-height: 1.75;
				}

				em {
					display: block;
					font-size: 0.75em;
					line-height: 1.2;
				}

				&.hidden {
					height: 0;
					opacity: 0;
				}

				&.shown {
					animation-name: reveal-form-field;
					animation-duration: 1s;
					animation-timing-function: ease;
					animation-fill-mode: forwards;
				}
			}

			.error-message {
				color: #f00;
				height: 1em;
				margin-top: 1em;
				font-size: 0.875em;
			}

			.input {
				appearance: none;
				font-size: 2em;
				font-family: serif;
				border-radius: 0;
				border-style: solid;
				border-width: 0.05em;
				border-color: #888;
				color: #333;
				margin: 1.5em 0;
				padding: 0;
				width: 4em;
				text-align: center;

				&.box {
					margin: 0 0 1em 0;
				}
			}

			input[type='radio'] {
				width: 0;
				height: 0;
				margin: 0;
				display: none;
			}

			label {
				background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath d='m0 0h20v20h-20z' stroke='%23000' stroke-width='2' fill='transparent'/%3E%3C/svg%3E");
				background-position: 0 50%;
				background-repeat: no-repeat;
				background-size: 0.75em;
				padding-left: 1.25em;
				position: relative;

				@keyframes draw-in {
					0% {
						height: 0em;
					}
					100% {
						height: 0.625em;
					}
				}

				&::before,
				&::after {
					content: '';
					position: absolute;
					top: 0.325em;
					width: 0.625em;
					height: 0;
					background-size: 0.625em;
					left: 0.0625em;
					animation-duration: 0.2s;
					animation-timing-function: ease;
					animation-fill-mode: forwards;
				}

				&::before {
					animation-delay: 0.2s;
					background-image: url("data:image/svg+xml,%3Csvg enable-background='new 0 0 64 64' height='64' viewBox='0 0 64 64' width='64' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%2326f' d='m53.1 56.6c-.3-.1-.5-.1-.8-.2-.9-.3-1.9-.5-2.7-1.1-.9-.7-1.5-1.6-2.3-2.5-.3-.3-.6-.5-1-.7-.8-.6-1.6-1.1-2.4-1.7-1.4-1-2.7-2-4.1-3-.4-.4-.8-1.1-1.3-1.4-1.4-.8-2.6-1.6-3.6-2.9-.3-.3-.8-.4-1.1-.7-1.2-1.1-2.3-2.3-3.5-3.4-2.8-2.5-5.7-5-8.5-7.5-1.1-1-2.2-2.1-3.4-3.1-1.3-1.2-2.5-2.3-3.8-3.4-.3-.3-.7-.5-1-.7-1.5-.8-2.4-2.2-3.7-3.2-1.1-.9-2.1-1.7-3.2-2.5-.7-.5-1.4-.9-2.1-1.4-1-.8-1.9-1.8-2.9-2.7-.1-.1-.3-.2-.4-.4 0-.1 0-.2 0-.3.5-.9 1-1.9 1.6-2.7.4-.6 1.1-1 1.5-1.5.7-1 1.6-1.2 2.7-1.3 1.1-.3 2.2-.7 3.3-.9h.5c.8.3 1.6.5 2.2 1 1 .8 1.9 1.9 2.9 2.8.6.6 1.2 1.1 1.8 1.6 1.3 1 2.6 2 3.9 3.1 1.3 1 2.5 2.1 3.8 3.2.6.5 1.3.9 2 1.4.1.1.2.1.2.2 1 1.8 2.8 2.8 4.2 4.2 2.2 2.4 4.8 4.4 7.2 6.7 1.1 1 2.1 2.1 3.2 3.1.8.8 1.7 1.4 2.6 2.1 1.3 1.1 2.4 2.2 3.8 3.1 1 .7 2.1 1.2 3.1 1.9 1.7 1.1 3.4 2.2 5.1 3.2.6.4 1.3.6 2 .9 1.5.5 2.8 1.3 3.3 2.8.2.4.2.9.4 1.4v1.2c-.1.2-.3.4-.3.7-.2.9-.4 1.9-1.1 2.5-1 .8-2 1.7-3.4 1.7-.1 0-.2.1-.3.2-1.5.2-3 .2-4.4.2z'/%3E%3C/svg%3E");
				}

				&::after {
					background-image: url("data:image/svg+xml,%3Csvg enable-background='new 0 0 64 64' height='64' viewBox='0 0 64 64' width='64' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%2326f' d='m55.1 10.9c-.1.3-.2.6-.3 1-.2.5-.4.8-.9 1.1-.7.5-1.2 1.2-1.7 1.9-.9 1.1-1.6 2.3-2.5 3.4-.7.7-1.5 1.2-2.3 1.7-.6.5-1.4.8-2 1.3-.5.3-.8.8-1.2 1.2-1.1 1.2-2.2 2.3-3.2 3.5-.8.8-1.5 1.7-2.2 2.6-1 1.1-2 2.3-2.8 3.5-1.2 1.7-2.5 3.2-3.9 4.7-1 1.1-1.7 2.3-2.6 3.5-.7.9-1.4 1.8-2.1 2.7-.7 1-1.4 2-2.1 3-.5.8-1.3 1.5-1.6 2.3-.6 1.4-1.6 2.4-2.9 3.3-.3.2-.5.7-.8 1-.2.2-.2.5-.4.7-1.5 1-2.9 2-4.8 2.1-1.2.1-2.4.2-3.7.4-.1 0-.1.1-.2.2-.2 0-.4 0-.7 0-.1-.1-.2-.1-.3-.2-1.1-.3-2.2-.7-2.8-1.8-.3-.6-.6-1.3-.9-1.9 0-.3 0-.7 0-1 .8-.3 1.3-.8 1.5-1.7 0-.2.2-.4.4-.5.8-.6 1.6-1.1 2.3-1.6 1.1-.9 2.1-1.8 3.2-2.7.5-.4.9-.9 1.4-1.4.1-.1.1-.2.2-.2.8-1.3 1.7-2.6 2.6-3.9.7-1 1.6-1.9 2.3-2.8 1.1-1.5 2.1-3 3.2-4.4s2.4-2.7 3.6-4.1c.8-.9 1.6-1.8 2.3-2.8 1.2-1.7 2.5-3.3 4.2-4.7.6-.5 1.1-1.3 1.6-1.9 1-1.1 2.3-2.1 3.1-3.3 1.2-1.9 3.2-2.8 4.8-4.1 1.2-.9 2.3-1.8 3.6-2.6 1-.6 1.9-1.4 3.3-1.1.5.1 1.1-.4 1.7-.6h.5c.9.2 1.4.7 1.8 1.5.3.6.8 1.1 1.2 1.7.1.3.1.7.1 1z'/%3E%3C/svg%3E");
				}
			}

			input[type='radio']:checked + label {
				&::before,
				&::after {
					animation-name: draw-in;
				}
			}

			input:focus,
			textarea:focus,
			button:focus,
			input[type='radio']:focus + label {
				outline: none !important;
				box-shadow: none !important;
				// background-color: red;
			}

			input[type='text'] {
				resize: none;
				width: 100%;
				height: 2em;
				background-color: transparent;
				background-image: url('/assets/textarea.svg');
				background-repeat: repeat;
				background-size: 2em;
				border: 0 none;
				margin-top: -0.5em;
				padding: 0 0.25em;
				font-family: 'homemade apple', script;
				font-size: 1em;
				line-height: 2em;
				color: #26f;
				text-align: center;
				overflow: hidden;
				display: block;
				box-sizing: border-box;
			}

			textarea {
				resize: none;
				width: 100%;
				height: 6em;
				background-color: transparent;
				background-image: url('/assets/textarea.svg');
				background-repeat: repeat;
				background-size: 2em;
				border: 0 none;
				margin-top: -0.5em;
				padding: 0 0.25em;
				font-family: 'homemade apple', script;
				font-size: 1em;
				line-height: 2em;
				color: #26f;
				text-align: center;
				overflow: hidden;
				display: block;
				box-sizing: border-box;
			}

			label {
				margin-right: 1em;

				&:last-of-type {
					margin-right: 0;
				}
			}

			.page-turn {
				cursor: pointer;
				position: absolute;
				width: 70%;
				mix-blend-mode: soft-light;
				right: 0;
				bottom: 0;
				transform: scale(0);
				transform-origin: 100% 100%;
				transition-property: transform;
				transition-duration: 2s;
				transition-timing-function: cubic-bezier(0.645, 0.045, 0.355, 1);
				transition-delay: 0s;
				pointer-events: none;

				img {
					display: block;
					width: 100%;
				}
			}

			@keyframes page-turn-tip-reveal {
				from {
					opacity: 0;
				}
				to {
					opacity: 0.8;
				}
			}

			@keyframes page-turn-tip-hide {
				from {
					opacity: 0.8;
				}
				to {
					opacity: 0;
				}
			}

			@keyframes page-turn-tip-breathe {
				from {
					opacity: 0.2;
				}
				to {
					opacity: 0.8;
				}
			}

			.page-turn-tip {
				position: absolute;
				width: 100%;
				bottom: 2em;
				font-size: 0.875em;
				text-align: center;
				opacity: 0;
				animation-direction: normal, alternate-reverse;
				animation-duration: 1s, 1s;
				animation-iteration-count: 1, infinite;
				animation-timing-function: ease, linear;
				pointer-events: none;
			}
		}
	}

	.spread {
		&.active {
			z-index: 3;

			.page {
				filter: none;
			}

			.page.left {
				transform: rotateY(0deg);
			}
		}
		&.active + .spread {
			z-index: 2;
		}
		&.complete {
			.page-turn,
			.page-turn-tip {
				pointer-events: all;
			}
			.page-turn-tip {
				animation-name: page-turn-tip-reveal, page-turn-tip-breathe;
				animation-delay: 1s, 2s;
			}
		}
		&.active.complete {
			.page-turn {
				transform: scale(1);
			}
			.page.right {
				clip-path: polygon(0% 0%, 100% 0%, 100% 87.25%, 63% 100%, 0% 100%);
			}
		}
		&.passed {
			z-index: 2;

			.page.left {
				transform: rotateY(0deg);
			}
			.page.right {
				transform: rotateY(-180deg);
			}
		}
	}
}

@media only screen and (max-width: 567px) {
	.book {
		height: 60vw;

		.spread.active.complete .page.right {
			clip-path: polygon(0% 0%, 100% 0%, 100% 89.5%, 66% 100%, 0% 100%);
		}

		.spread .page .img-full {
			max-width: 90%;
		}

		.spread .page .body-text {
			width: 30vw;
		}
	}
}
</style>

<script>
import axios from 'axios';

const baseURL = process.env.NODE_ENV == 'development' ? '//localhost:3000/guests/' : 'guests/';
//  process.env.NODE_ENV == 'development' ? 'https://jennandsteve.ca/guests/' : 'guests/'

export default {
	data() {
		return this.initialState();
	},
	mounted() {
		this.initialCamera();
		// this.focusInput('id');
		this.lookupGuest();
	},
	methods: {
		spreadWelcomeNext() {
			if (this.guest.accepts == 'no') {
				this.modifyGuest();
			}
			if (this.guest.accepts == 'yes') {
				this.step = 2;
			}
			this.cameraPan();
		},
		spreadAlcoholNext() {
			if (this.guest.hasGuest == 'no') {
				if (this.guest.hasChildren == 'no') {
					this.modifyGuest();
				} else {
					this.step = 8;
				}
			}
			if (this.guest.hasGuest == 'yes') {
				this.step = 5;
			}
			this.cameraPan();
		},
		spreadGuestAlcoholNext() {
			if (this.guest.hasChildren == 'no') {
				this.modifyGuest();
			} else {
				this.step = 8;
			}
			this.cameraPan();
		},
		spreadChild1MealNext() {
			if (this.guest.hasChildren != 'two') {
				this.modifyGuest();
			} else {
				this.step = 10;
			}
			this.cameraPan();
		},
		spreadThankYouPrev() {
			if (this.guest.accepts == 'yes') {
				if (this.guest.hasChildren == 'two') {
					this.step = 11;
				} else if (this.guest.hasChildren == 'one') {
					this.step = 9;
				} else {
					if (this.guest.hasGuest == 'yes') {
						this.step = 7;
					} else {
						this.step = 4;
					}
				}
			} else {
				this.step = 1;
			}
			this.cameraPan();
		},
		spreadChild1NamePrev() {
			if (this.guest.hasGuest == 'yes') {
				this.step = 7;
			} else {
				this.step = 4;
			}
			this.cameraPan();
		},
		prev() {
			this.step--;
			this.cameraPan();
		},
		next() {
			this.step++;
			this.cameraPan();
		},
		initialState() {
			return {
				step: 1,
				errorMessage: '',
				guest: [],
			};
		},
		reset() {
			Object.assign(this.$data, this.initialState());
		},
		lookupGuest() {
			const linkID = new URLSearchParams(window.location.search).get('linkid');
			console.log(linkID);
			if (linkID) {
				axios
					.get(`${baseURL}${linkID}`)
					.then((response) => {
						this.guest = response.data;
					})
					.catch((error) => {
						this.errorMessage = error.message;
					});
			} else {
				this.errorMessage = 'Please enter an ID.';
			}
		},
		modifyGuest() {
			axios
				.put(`${baseURL}${this.guest.id}`, this.guest)
				.then((response) => {
					this.step = 12;
				})
				.catch((error) => {
					console.log(error);
				});
		},
		cameraPan() {
			const app = document.getElementById('app');

			app.classList.remove('pan', 'right');
			app.classList.add('zoom-out');

			setTimeout(function() {
				app.classList.remove('zoom-out');
				app.classList.add('pan', 'left');
			}, 2500);

			setTimeout(function() {
				app.classList.remove('left');
				app.classList.add('right');
			}, 5000);
		},
		initialCamera() {
			const app = document.getElementById('app');

			setTimeout(function() {
				app.classList.add('pan', 'right');
			}, 2500);
		},
	},
};
</script>
