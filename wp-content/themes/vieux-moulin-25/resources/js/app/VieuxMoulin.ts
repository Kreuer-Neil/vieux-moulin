import {settings} from "./settings";
import {Slider} from "./Slider";

export class VieuxMoulin {
    private readonly noJsClassName: string;
    private readonly noJsClasses: NodeListOf<HTMLElement>;
    private readonly slider: Slider

    constructor() {
        this.noJsClassName = settings.noJsClassName;
        this.noJsClasses = document.querySelectorAll('.' + this.noJsClassName);
        this.slider = new Slider();

        addEventListener('load', () => this.init());
    }

    init() {
        this.removeNoJsClasses();
        this.slider.init();
    }

    private removeNoJsClasses() {
        this.noJsClasses.forEach((noJsClass) => {
            noJsClass.classList.remove(this.noJsClassName);
        });
    }
}