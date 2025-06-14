import {settings} from "./settings";


export class Slider {
    private readonly leftButton: HTMLElement;
    private readonly rightButton: HTMLElement;
    private readonly sliderContainer: HTMLElement;


    constructor() {
        this.leftButton = document.querySelector('.' + settings.slider.classNames.buttons.left);
        this.rightButton = document.querySelector('.' + settings.slider.classNames.buttons.right);
        this.sliderContainer = document.querySelector('.' + settings.slider.classNames.container);
    }

    public init() {
        if (!(this.leftButton === null)) {
            this.eventListeners();
        }
    }

    private eventListeners() {
        this.leftButton.addEventListener('click', (e) => {
            this.sliderScroll('left');
        });
        this.leftButton.addEventListener('keydown', (e) => {
            if (settings.pressedKeys.includes(e.key)) {
                this.sliderScroll('left');
            }
        });
        this.rightButton.addEventListener('click', (e) => {
            this.sliderScroll('right');
        });
        this.rightButton.addEventListener('keydown', (e) => {
            if (settings.pressedKeys.includes(e.key)) {
                this.sliderScroll('right');
            }
        });
    }

    private sliderScroll(side: string) {
        let scrollValue = this.sliderContainer.offsetWidth;
        const actualScroll = this.sliderContainer.scrollLeft;
        if (side === 'left') {
            scrollValue = -scrollValue;
        }
        this.sliderContainer.scrollTo({left: actualScroll + scrollValue, behavior: "smooth"});
    }
}