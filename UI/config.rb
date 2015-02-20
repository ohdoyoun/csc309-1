css_dir = "Styles/Generated"
sass_dir = "Styles/Sass"
images_dir = "Images"
javascripts_dir = "Scripts"

require 'fileutils'
on_stylesheet_saved do |file|
  if File.exists?(file) && File.basename(file) == "style.css"
    puts "Moving: #{file}"
    FileUtils.mv(file, File.dirname(file) + "/../../" + File.basename(file))
  end
end