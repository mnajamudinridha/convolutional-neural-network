from tensorboard import default
from tensorboard import program

tb = program.TensorBoard(default.PLUGIN_LOADERS, default.get_assets_zip_provider())
tb.configure(argv=['--logdir', 'tensorboard'])
tb.main()