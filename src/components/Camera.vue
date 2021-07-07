<template>
	<div id="camera" :class="[orientation, userAgent]">
		<div id="viewfinder" class="viewfinder">
			<div id="gallery"></div>
			<div id="sizing-box">
				<video id="player" muted playsinline></video>
				<img id="timer-display" v-show="this.timerActive" src="" />
			</div>
		</div>
		<div id="controls">
			<div class="button left" id="set-timer" v-on:click="this.timerEnabled = !this.timerEnabled" v-bind:class="{ active: this.timerEnabled }">
				Set Timer
			</div>
			<div class="button center" id="shutter" v-on:click="shutterHandler()">
				Take Picture
			</div>
			<div class="button right" id="change-camera" v-on:click="changeCamera()">
				Change Camera
			</div>
		</div>
	</div>
	<canvas id="canvas" width="768" height="1024"></canvas>
</template>

<style lang="scss">
#camera {
	display: flex;
	user-select: none;
	height: 100%;

	#viewfinder {
		flex-grow: 1;
		flex-shrink: 1;
		position: relative;
		overflow: hidden;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	#sizing-box {
		overflow: hidden;
		position: relative;
		width: 0;
		height: 0;

		&::before,
		&::after {
			content: '';
			position: absolute;
			width: 101%;
			height: 101%;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			background-size: 100% 100%;
			pointer-events: none;
		}

		&::before {
			z-index: 2;
		}

		&::after {
			z-index: 4;
		}

		#player {
			display: block;
			position: absolute;
			z-index: 0;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		#timer-display {
			position: absolute;
			z-index: 1;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			opacity: 0.75;
		}

		@keyframes flash {
			0% {
				filter: brightness(10);
			}
			100% {
				filter: brightness(1);
			}
		}

		@keyframes slide-left {
			0% {
				transform: translateX(0);
			}
			100% {
				transform: translateX(-101%);
			}
		}

		.photo {
			position: absolute;
			z-index: 3;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			animation-duration: 0.5s, 1s;
			animation-timing-function: ease;
			animation-fill-mode: both;
		}
	}

	#gallery {
		flex-grow: 0;
		flex-shrink: 0;
		align-self: stretch;
		display: flex;
		align-items: stretch;
		overflow: hidden;
		padding: 6.25vh 3.125vw;

		.photo {
			object-fit: cover;
			flex-grow: 0;
			flex-shrink: 0;
			mask-image: radial-gradient(circle, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.8) 15%, rgba(0, 0, 0, 0.5) 100%);
			transform: scale(0.85);
			animation-name: flash;
			animation-duration: 0.5s;
			animation-timing-function: ease;
			animation-fill-mode: both;
		}
	}

	#controls {
		flex-grow: 0;
		flex-shrink: 0;
		display: flex;
		align-items: stretch;
		justify-content: space-between;
		background-color: #151515;
		background-image: url('/assets/leather.jpg');
		background-position: 50% 50%;
		background-size: 50vh;
		position: relative;

		&::before {
			content: '';
			background-color: #202020;
			position: absolute;
			border-style: solid;
			border-top-color: rgba(255, 255, 255, 0.0325);
			border-right-color: rgba(0, 0, 0, 0.25);
			border-bottom-color: rgba(0, 0, 0, 0.25);
			border-left-color: rgba(255, 255, 255, 0.0325);
		}

		.button {
			display: flex;
			text-indent: -999px;
			overflow: hidden;
			background-position: 50% 50%;
			background-size: 100% 100%;
			background-repeat: no-repeat;
		}
	}

	&.portrait-primary {
		flex-direction: column;

		#viewfinder {
			flex-direction: column;

			#sizing-box {
				&::before {
					background-image: url('/assets/viewfinder-glass-portrait.png');
				}

				&::after {
					background-image: url('/assets/viewfinder-vignette-portrait.png');
				}

				#player {
					border-radius: 2vw;
				}

				#timer-display {
					width: auto;
					height: 18.75%;
				}
				.photo {
					animation-name: flash, slide-left;
				}
			}
		}

		#gallery {
			height: 20vw;
			padding: 6.25vw;
			overflow-x: auto;

			.photo {
				width: 16.66%;
				border-radius: 1vw;
			}
		}

		#controls {
			height: 10vh;
			margin-top: 6.25vw;
			padding: 2.5vh;

			&::before {
				width: 100%;
				height: 0.25em;
				top: -0.25em;
				left: 0;
				border-width: 1px 0;
			}

			.button {
				width: 10vh;

				&#set-timer {
					background-image: url('/assets/timer-disabled-portrait.png');
					&.active {
						background-image: url('/assets/timer-enabled-portrait.png');
					}
				}

				&#shutter {
					background-image: url('/assets/shutter-portrait.png');
					transform: scale(1.125);
				}

				&#change-camera {
					background-image: url('/assets/change-camera-portrait.png');
				}
			}
		}
	}

	&.landscape-primary {
		flex-direction: row;

		#viewfinder {
			flex-direction: row;

			#sizing-box {
				&::before {
					background-image: url('/assets/viewfinder-glass-landscape.png');
				}

				&::after {
					background-image: url('/assets/viewfinder-vignette-landscape.png');
				}

				#player {
					border-radius: 2vh;
				}

				#timer-display {
					width: 18.75%;
					height: auto;
				}

				.photo {
					animation-name: flash, slide-left;
				}
			}
		}

		#gallery {
			width: 20vh;
			padding: 6.25vh;
			flex-direction: column;
			overflow-y: auto;

			.photo {
				height: 16.66%;
				border-radius: 1vh;
			}
		}

		#controls {
			width: 25vw;
			height: 100%;
			margin-left: 6.25vh;
			padding: 0;
			flex-direction: column;
			justify-content: start;
			background-image: url('/assets/bg-landscape-2.png'), url('/assets/leather.jpg');
			background-repeat: repeat-x, repeat;
			background-position: 50% 0%, 0% 27.5%;
			background-size: auto 27.5%, 100vh;

			&::before {
				width: 0.25em;
				height: 100%;
				top: 0;
				left: -0.25em;
				border-width: 0 1px;
			}

			.button {
				width: 24vh;
				height: 24vh;
				margin: 0 3vw;

				&#shutter {
					background-image: url('/assets/shutter-landscape.png');
					background-position: 50% 42.5%;
					background-size: 100% auto;
					order: 0;
					height: 27.5%;
					margin-left: auto;
				}

				&#change-camera {
					background-image: url('/assets/change-camera-landscape.png');
					order: 1;
					margin: 1.5vw 0 0 3vw;
				}

				&#set-timer {
					background-image: url('/assets/timer-disabled-landscape.png');
					order: 2;
					margin: auto 0 1.5vw 3vw;

					&.active {
						background-image: url('/assets/timer-enabled-landscape.png');
					}
				}
			}
		}
	}
}

// should target chrome only
#camera.portrait-primary.not-chrome-ios {
	height: 100%;
}
#camera.landscape-primary.not-chrome-ios {
	height: 100vh;
}
#camera.portrait-primary.chrome-ios,
#camera.landscape-primary.chrome-ios {
	height: 100%;
}

#canvas {
	display: none;
}
</style>

<script>
// import axios from "axios";

// const baseURL =
// 	process.env.NODE_ENV === "development"
// 		? "//localhost:3000/photos/"
// 		: "photos/";

export default {
	data() {
		return this.initialState();
	},
	mounted() {
		// this.userAgent = navigator.userAgent;
		this.canvas = document.getElementById('canvas');
		this.vf = document.getElementById('viewfinder');
		this.sb = document.getElementById('sizing-box');
		this.ga = document.getElementById('gallery');
		this.player = document.getElementById('player');
		this.td = document.getElementById('timer-display');
		this.constraints = {
			video: { deviceId: this.activeCameraID },
		};
		this.browserDetect();
		this.getCameras();
		this.dynamicResize();
		window.addEventListener('resize', this.resizeHandler);
		setInterval(() => {
			if (this.resized) {
				this.dynamicResize();
			}
		}, 500);
	},
	methods: {
		initialState() {
			return {
				userAgent: 'not-chrome-ios',
				resized: false,
				orientation: 'portrait-primary',
				cameras: [],
				facingMode: 'environment',
				activeCameraID: '',
				activeCameraIndex: 0,
				photo: '',
				context: '',
				constraints: {
					facingMode: this.facingMode,
				},
				timerEnabled: false,
				timerActive: false,
			};
		},
		browserDetect() {
			if (navigator.userAgent.toLowerCase().indexOf('crios') > -1) {
				this.userAgent = 'chrome-ios';
			}
		},
		resizeHandler() {
			this.resized = true;
		},
		dynamicResize() {
			// reset
			this.resized = false;
			// "orientation" check and resizing canvas accordingly
			if (window.innerWidth < 568) {
				this.orientation = 'portrait-primary';
				this.canvas.setAttribute('width', 768);
				this.canvas.setAttribute('height', 1024);
			} else {
				this.orientation = 'landscape-primary';
				this.canvas.setAttribute('width', 1024);
				this.canvas.setAttribute('height', 768);
			}
			setTimeout(() => {
				// viewfinder resizing
				const gaW = this.ga.clientWidth;
				const gaH = this.ga.clientHeight;
				if (this.orientation == 'portrait-primary') {
					// 3:4 (portrait)
					const vfW = this.vf.clientWidth - this.vf.clientWidth / 8;
					const vfH = this.vf.clientHeight;
					if ((vfW / 3) * 4 + gaH > vfH) {
						// VF height is too narrow
						this.sb.style.height = vfH - gaH + 'px';
						this.sb.style.width = ((vfH - gaH) / 4) * 3 + 'px';
					} else {
						this.sb.style.width = vfW + 'px';
						this.sb.style.height = (vfW / 3) * 4 + 'px';
					}
				} else if (this.orientation == 'landscape-primary') {
					// 4:3 (landscape)
					const vfW = this.vf.clientWidth;
					const vfH = this.vf.clientHeight - this.vf.clientHeight / 8;
					if ((vfH / 3) * 4 + gaW > vfW) {
						// VF width is too narrow
						this.sb.style.width = vfW - gaW + 'px';
						this.sb.style.height = ((vfW - gaW) / 4) * 3 + 'px';
					} else {
						this.sb.style.width = (vfH / 3) * 4 + 'px';
						this.sb.style.height = vfH + 'px';
					}
				}
			}, 500);
		},
		getCameras() {
			navigator.mediaDevices
				.enumerateDevices()
				.then((devices) => {
					devices.forEach((device) => {
						if (device.kind == 'videoinput' && device.label != 'OM-D WebCam Beta (D_We:bCam)') {
							this.cameras.push(device.deviceId);
						}
					});
					this.activeCameraID = this.cameras[this.activeCameraIndex];
					this.initializeCamera();
				})
				.catch((err) => {
					console.log(err.name + ': ' + err.message);
				});
		},
		initializeCamera() {
			if (this.activeCameraID.length) {
				this.constraints = {
					video: {
						deviceId: this.activeCameraID,
					},
				};
			} else {
				this.constraints = {
					video: {
						facingMode: this.facingMode,
					},
				};
			}
			navigator.mediaDevices
				.getUserMedia(this.constraints)
				.then((stream) => {
					this.player.srcObject = stream;
					this.player.play();
				})
				.catch((err) => {
					console.log(err.name + ': ' + err.message);
				});
		},
		changeCamera() {
			if (this.activeCameraID.length) {
				this.activeCameraIndex++;
				this.activeCameraIndex = this.activeCameraIndex % this.cameras.length;
				this.activeCameraID = this.cameras[this.activeCameraIndex];
			} else {
				if (this.facingMode == 'environment') {
					this.facingMode = 'user';
				} else {
					this.facingMode = 'environment';
				}
			}
			this.initializeCamera();
		},
		takePicture() {
			const context = this.canvas.getContext('2d');

			context.drawImage(this.player, 0, 0, this.canvas.width, this.canvas.height);

			this.photo = this.canvas.toDataURL('image/jpeg', 0.5);

			const img = document.createElement('img');
			const img2 = document.createElement('img');

			img.src = this.photo;
			img.classList.add('photo');
			this.sb.appendChild(img);

			img2.src = this.photo;
			img2.classList.add('photo');
			this.ga.prepend(img2);

			// axios
			// 	.post(`${baseURL}`, this.photo)
			// 	.then((response) => {
			// 		console.log(response);
			// 	})
			// 	.catch((error) => {
			// 		console.log(error);
			// 	});
		},
		shutterHandler() {
			if (this.timerEnabled && !this.timerActive) {
				this.timerActive = true;
				this.td.src =
					'data:image/gif;base64,R0lGODlhgAGAAfABAP+qAAAAACH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNi4wLWMwMDYgNzkuZGFiYWNiYiwgMjAyMS8wNC8xNC0wMDozOTo0NCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ1dWlkOjY1RTYzOTA2ODZDRjExREJBNkUyRDg4N0NFQUNCNDA3IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjc1RTg1RTdFRDYyQzExRUI5RUM0RUI4OEE5Njk3Njk3IiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc1RTg1RTdERDYyQzExRUI5RUM0RUI4OEE5Njk3Njk3IiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIElsbHVzdHJhdG9yIDI1LjMgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo4ODgxZGE0ZC1jODVlLTRkZmQtYTRkNi01NjhlOTMxOTkxZmYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6YWVmMDI0ZTctMTk1ZC00NzY4LTg1ODMtNzg0YWM3MGM0YzZmIi8+IDxkYzp0aXRsZT4gPHJkZjpBbHQ+IDxyZGY6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';
				setTimeout(
					function() {
						this.takePicture();
						this.timerActive = false;
						this.td.src = '';
					}.bind(this),
					5000
				);
			} else if (!this.timerEnabled && !this.timerActive) {
				this.takePicture();
			}
		},
	},
};
</script>
