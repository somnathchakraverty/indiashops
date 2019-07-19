<?php
$specs['inches'] = "The screen size of the cellphone in inches diagonally";
$specs['pixels'] = "A pixel is a single point, or dot, in a digital photograph or on a mobile phone (or other) display. The number of pixels in an image or display that make up the X and Y axes are often referred to as the resolution";
$specs['capacitive touchscreen'] = "Capacitive touchscreen displays rely on the electrical properties of the human body to detect when and where on a display the user touches. Because of this, capacitive displays can be controlled with very light touches of a finger and generally cannot be used with a mechanical stylus or a gloved hand.";
$specs['AMOLED capacitive touchscreen'] = "Super AMOLED is a term for an AMOLED display with an integrated digitizer: the layer that detects touch is integrated into the screen, rather than overlaid on top of it. According to Samsung, Super AMOLED reflects one-fifth as much sunlight compared to the first generation AMOLED";
$specs['Corning Gorilla Glass'] = "Gorilla Glass offers enhanced scratch resistance, reduced scratch visibility and better retained strength once a scratch does occur";
$specs['Ion-strengthened glass'] = "The term Ion-Strengthened Glass refers to a method to chemically increase the hardness of a piece of glass by heating the glass and exchanging Sodium ions in the glass with Potassium ions brought by a bath of potassium salt";
$specs['screen-to-body ratio'] = "The Display to body ratio is a simple data that tells you how much of the surface the screen represents when compared to the whole device. For example, a device with a ratio of 50% would have as much body surface visible from the front as it has screen surface";
$specs['LED flash'] = "An LED flashlight. A hand-held spotlight with a large reflector. A flashlight (torch in Commonwealth English) is a portable hand-held electric light. Usually, the source of the light is a small incandescent light bulb or light-emitting diode (LED)";
$specs['HDR'] = "HDR is an acronym that stands for High Dynamic Range. It is a technique in Photography to capture a greater dynamic range of Brightness, between the lightest and darkest area of a scene or an object being photographed";
$specs['fps'] = "Frame rate, is the frequency (rate) at which an imaging device displays consecutive images called frames. The term applies equally to film and video cameras, computer graphics, and motion capture systems. Frame rate is expressed in frames per second (FPS)";
$specs['geo-tagging'] = "Geotagging is the process of adding geographical information to your photograph. The data usually consists of coordinates like latitude and longitude, but may even include bearing, altitude, distance and place names";
$specs['mAh'] = "This is a unit of electric charge, and it's the most common way to express the capacity of small batteries. (Bigger batteries are labeled in ampere hours; 1 Ah = 1000 mAh.) You can calculate the capacity of a battery by multiplying the discharge current by the duration of time that the battery can supply that much current";
$specs['Nano-SIM'] = "Nano SIM is both smaller and approximately 15% thinner than the earlier Micro SIM (3FF) standard as well as the Mini SIM (2FF) cards that were ubiquitous for many years and people commonly refer to simply as SIM cards";
$specs['Accelerometer'] = "An instrument for measuring the acceleration of a moving or vibrating body";
$specs['gyro'] = "Gyrometer adds an additional dimension to the information supplied by the accelerometer by tracking rotation or twist";
$specs['proximity'] = "A proximity sensor is a sensor able to detect the presence of nearby objects without any physical contact";
$specs['Android OS'] = "Android is a mobile operating system (OS) currently developed by Google, based on the Linux kernel and designed primarily for touchscreen mobile devices such as smartphones and tablets";
$specs['LED-backlit IPS LCD'] = "An LED-backlit LCD is a flat panel display which uses LED backlighting instead of the cold cathode fluorescent (CCFL) backlighting used by most other LCDs";
$specs['oleophobic coating'] = "Oleophobic coating provides a certain amount of finger smudge resistance to your smartphone's display; it doesn't make it fingerprint proof, mind you, but keeps the grease at bay, not allowing it to adhere to the glass";
$specs['barometer'] = "A barometer is a scientific instrument used to measure atmospheric pressure";
@unlink("mobile_specs.json");
file_put_contents("mobile_specs.json", json_encode( $specs ) );
?>