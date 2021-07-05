<template>
	<div id="camera" :class="[orientation]">
		<div id="viewfinder" class="viewfinder">
			<div id="gallery"></div>
			<div id="sizing-box">
				<video id="player" muted playsinline></video>
			</div>
		</div>
		<div id="controls">
			<div
				class="button left"
				id="set-timer"
				v-on:click="this.timerEnabled = !this.timerEnabled"
				v-bind:class="{ active: this.timerEnabled }"
			>
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
	height: 100%;
	display: flex;

	#viewfinder {
		flex-grow: 1;
		flex-shrink: 1;
		position: relative;
		z-index: 0;
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
		border-radius: 0.25em;
		box-shadow: 0.25em 0.25em 0.5em rgba(0, 0, 0, 0.5);

		&::before,
		&::after {
			content: "";
			position: absolute;
			z-index: 1;
			width: 101%;
			height: 101%;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			background-size: 100% 100%;
		}

		video {
			display: block;
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		@keyframes flash {
			0% {
				filter: brightness(10);
			}
			100% {
				filter: brightness(1);
			}
		}

		@keyframes slide {
			0% {
				transform: translateX(0);
			}
			100% {
				transform: translateX(-100%);
			}
		}

		.photo {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			animation-name: flash, slide;
			animation-duration: 0.5s, 1s;
			animation-timing-function: ease;
			animation-fill-mode: both;
		}
	}

	#gallery {
		flex-grow: 0;
		flex-shrink: 0;
		display: flex;
		align-items: stretch;
		overflow: hidden;
		padding: 1em;

		.photo {
			object-fit: cover;
			flex-grow: 0;
			flex-shrink: 0;
			transform: scale(0.9);
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
		justify-content: space-around;
		background-color: #151515;
		background-image: url("/assets/leather.jpg");
		background-position: 50% 50%;
		background-size: 20em;
		position: relative;

		&::before {
			content: "";
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

		#set-timer.active {
			background-color: rgba(255, 0, 0, 0.25);
		}
	}

	&.portrait-primary {
		flex-direction: column;

		#viewfinder {
			flex-direction: column;

			#sizing-box {
				&::before {
					background-image: url("/assets/viewfinder-glass-portrait.png");
				}

				&::after {
					background-image: url("/assets/viewfinder-vignette-portrait.png");
				}
			}
		}

		#gallery {
			height: 28vw;
			overflow-x: auto;

			.photo {
				width: 16.66%;
			}
		}

		#controls {
			height: 6em;
			margin-top: 1em;
			padding: 1em;

			&::before {
				width: 100%;
				height: 0.25em;
				top: -0.25em;
				left: 0;
				border-width: 1px 0;
			}

			.button {
				width: 4em;

				&#set-timer {
					background-image: url("/assets/set-timer-portrait.png");
				}

				&#shutter {
					background-image: url("/assets/shutter-portrait.png");
					transform: scale(1.125);
				}

				&#change-camera {
					background-image: url("/assets/change-camera-portrait.png");
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
					background-image: url("/assets/viewfinder-glass-landscape.png");
				}

				&::after {
					background-image: url("/assets/viewfinder-vignette-landscape.png");
				}
			}
		}

		#gallery {
			width: 27.5vh;
			height: 100%;
			flex-direction: column;
			overflow-y: auto;

			.photo {
				height: 16.66%;
			}
		}

		#controls {
			width: 12em;
			height: 100%;
			margin-left: 1.125em;
			padding: 0;
			flex-direction: column;
			justify-content: start;
			background-image: url("/assets/bg-landscape-2.png"),
				url("/assets/leather.jpg");
			background-repeat: repeat-x, repeat;
			background-position: 50% 0%, 50% 50%;
			background-size: auto 27.5%, 20em;

			&::before {
				width: 0.25em;
				height: 100%;
				top: 0;
				left: -0.25em;
				border-width: 0 1px;
			}

			.button {
				width: 5em;
				height: 5em;
				margin: 0 1.5em;
			}

			#shutter {
				width: 5em;
				background-image: url("/assets/shutter-landscape.png");
				background-position: 50% 42.5%;
				background-size: 100% auto;
				order: 0;
				height: 27.5%;
				margin-left: auto;
			}

			#change-camera {
				background-image: url("/assets/change-camera-landscape.png");
				order: 1;
				margin: 0.5em 0 0 1.5em;
			}

			#set-timer {
				background-image: url("/assets/set-timer-landscape.png");
				order: 2;
				margin: auto 0 0.5em 1.5em;
			}
		}
	}
}

#canvas {
	display: none;
}
</style>

<script>
import axios from "axios";

const baseURL =
	process.env.NODE_ENV === "development"
		? "//localhost:3000/photos/"
		: "photos/";

export default {
	data() {
		return this.initialState();
	},
	mounted() {
		this.player = document.getElementById("player");
		this.canvas = document.getElementById("canvas");
		this.constraints = {
			video: { deviceId: this.activeCameraID },
		};

		this.getCameras();
		this.dynamicResize();

		window.addEventListener("resize", this.resizeHandler);

		setInterval(() => {
			if (this.resized == "yes") {
				this.dynamicResize();
			}
		}, 500);
	},
	methods: {
		initialState() {
			return {
				resized: "no",
				orientation: "portrait-primary",
				cameras: [],
				facingMode: "environment",
				activeCameraID: "",
				activeCameraIndex: 0,
				photo: "",
				context: "",
				constraints: {
					facingMode: this.facingMode,
				},
				timerEnabled: false,
			};
		},
		resizeHandler() {
			this.resized = "yes";
		},
		dynamicResize() {
			// orientation check
			if (window.innerWidth < 568) {
				this.orientation = "portrait-primary";
				this.canvas.setAttribute("width", 768);
				this.canvas.setAttribute("height", 1024);
			} else {
				this.orientation = "landscape-primary";
				this.canvas.setAttribute("width", 1024);
				this.canvas.setAttribute("height", 768);
			}
			setTimeout(() => {
				// viewfinder resizing
				const vf = document.getElementById("viewfinder");
				const sb = document.getElementById("sizing-box");
				const ga = document.getElementById("gallery");
				const vfW = vf.clientWidth - 32;
				const vfH = vf.clientHeight - 32;
				const gaW = ga.clientWidth;
				const gaH = ga.clientHeight;
				if (this.orientation == "portrait-primary") {
					// 3:4 (portrait)
					if ((vfW / 3) * 4 + gaH > vfH) {
						// VF height is too narrow
						sb.style.height = vfH - gaH + "px";
						sb.style.width = ((vfH - gaH) / 4) * 3 + "px";
					} else {
						sb.style.width = vfW + "px";
						sb.style.height = (vfW / 3) * 4 + "px";
					}
				} else if (this.orientation == "landscape-primary") {
					// 4:3 (landscape)
					if ((vfH / 3) * 4 + gaW > vfW) {
						// VF width is too narrow
						sb.style.width = vfW - gaW + "px";
						sb.style.height = ((vfW - gaW) / 4) * 3 + "px";
					} else {
						sb.style.width = (vfH / 3) * 4 + "px";
						sb.style.height = vfH + "px";
					}
				}
			}, 500);
			// reset
			this.resized = "no";
		},
		getCameras() {
			navigator.mediaDevices
				.enumerateDevices()
				.then((devices) => {
					devices.forEach((device) => {
						if (
							device.kind == "videoinput" &&
							device.label != "OM-D WebCam Beta (D_We:bCam)"
						) {
							// console.log(device.label);
							this.cameras.push(device.deviceId);
						}
					});
					this.activeCameraID = this.cameras[this.activeCameraIndex];
					this.initializeCamera();
				})
				.catch((err) => {
					console.log(err.name + ": " + err.message);
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
					console.log(err.name + ": " + err.message);
				});
		},
		changeCamera() {
			if (this.activeCameraID.length) {
				this.activeCameraIndex++;
				this.activeCameraIndex = this.activeCameraIndex % this.cameras.length;
				this.activeCameraID = this.cameras[this.activeCameraIndex];
			} else {
				if (this.facingMode == "environment") {
					this.facingMode = "user";
				} else {
					this.facingMode = "environment";
				}
			}
			this.initializeCamera();
		},
		takePicture() {
			const context = this.canvas.getContext("2d");
			context.drawImage(
				this.player,
				0,
				0,
				this.canvas.width,
				this.canvas.height
			);

			this.photo = this.canvas.toDataURL("image/jpeg", 0.5);

			const container = document.getElementById("sizing-box");
			const gallery = document.getElementById("gallery");
			const img = document.createElement("img");
			const img2 = document.createElement("img");

			img.src = this.photo;
			img.classList.add("photo");
			container.appendChild(img);

			img2.src = this.photo;
			img2.classList.add("photo");
			gallery.prepend(img2);

			axios
				.post(`${baseURL}`, this.photo)
				.then((response) => {
					console.log(response);
				})
				.catch((error) => {
					console.log(error);
				});
		},
		shutterHandler() {
			if (this.timerEnabled) {
				setTimeout(() => this.takePicture(), 5000);
			} else {
				this.takePicture();
			}
		},
	},
};
</script>
