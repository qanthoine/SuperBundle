#SuperBundle
Projet pour Formation PHP / Symfony

#Presentation :
SuperBundle is a Bundle for Symfony (3.0.6), it create customs pages by an admin panel.
Pages are accessible by this route "YourDomain/page/{slug of the title}" and the Admin Panel by this route "YourDomain/admin" but you need an account with administrator role (look Requirement). This Bundle use TinyMCE for add and edit page.
<pre><code>
- V2: 
Now you can create Category, saves page's modifications (can turn off/on by parameters).<br>
URL as been changed for access in your page : YourDomain/page/{slug of the category}/{slug of the title}.<br>
You can moderate access to page with Role in access_control.<br>
</pre></code>
#Requierement :
For use this bundle you need :

- FOS UserBundle (<a href="https://symfony.com/doc/master/bundles/FOSUserBundle/index.html">installed and configured)</a>.<br>
- Symfony configured (Mysql, ...).<br>
- Account with ROLE_ADMIN for access in Admin panel.

#Configuration of Bundle :
- Download the Bundle and move (or unzip) in the Vendor directory of your project.
- Add the route in your app/AppKernel (in public fonction registerBundles) :
<pre><code>new SuperBundle\SuperBundle(),</pre></code>
- Update Doctrine schema (command).
<pre><code>php bin/console doctrine:schema:update --force</pre></code>
- Install Asset for css (command).
<pre><code>php bin/console assets:install --symlink</pre></code>
- Add Access_control page for protect Admin panel (app/config/security.yml).
<pre><code>- { path: ^/admin, role: ROLE_ADMIN }</pre></code>
<pre><code>- { path: ^/admin/, role: ROLE_ADMIN }</pre></code>
<pre><code>- { path: ^/page/, role: IS_AUTHENTICATED_ANONYMOUSLY } #other param : ROLE_ADMIN or ROLE_USER</pre></code>
- Add in app/config/parameters.yml
<pre><code>saves: true # true or false</pre></code>
This line is for configure the saves of modification in your custom pages<br>
<p><strong>Now for create your first page, you need to create first category (else it don't work :)</strong></p>
