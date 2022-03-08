import { startStimulusApp } from '@symfony/stimulus-bridge';
import Toastr_controller from "./controllers/toastr_controller";

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);

// ce qui permet d'enregistrer mon controller
// app.register('toastr', Toastr_controller);