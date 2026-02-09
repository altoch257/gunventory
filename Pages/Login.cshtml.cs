using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using Gunventory.Data;
using System.Security.Claims;
using Microsoft.AspNetCore.Authentication;
using BCrypt.Net;

namespace Gunventory.Pages;

public class LoginModel : PageModel
{
    private readonly GunventoryContext _context;

    public LoginModel(GunventoryContext context)
    {
        _context = context;
    }

    [BindProperty]
    public string Username { get; set; } = string.Empty;

    [BindProperty]
    public string Password { get; set; } = string.Empty;

    public string StatusMsg { get; set; } = string.Empty;

    public void OnGet()
    {
    }

    public async Task<IActionResult> OnPostAsync()
    {
        if (string.IsNullOrEmpty(Username) || string.IsNullOrEmpty(Password))
        {
            StatusMsg = "Please enter username and password.";
            return Page();
        }

        var user = await _context.Users
            .Include(u => u.Role)
            .FirstOrDefaultAsync(u => u.Username.ToLower() == Username.ToLower());

        if (user != null && BCrypt.Net.BCrypt.Verify(Password, user.Password))
        {
            var claims = new List<Claim>
            {
                new Claim(ClaimTypes.Name, user.Username),
                new Claim("Id", user.Id.ToString()),
                new Claim("FirstName", user.FirstName),
                new Claim("LastName", user.LastName),
                new Claim(ClaimTypes.Email, user.Email),
                new Claim(ClaimTypes.Role, user.RoleId.ToString())
            };

            var claimsIdentity = new ClaimsIdentity(claims, "CookieAuth");

            var authProperties = new AuthenticationProperties
            {
                //AllowRefresh = <bool>,
                // ExpiresUtc = DateTimeOffset.UtcNow.AddMinutes(10),
                // IsPersistent = true,
                // IssuedUtc = <DateTimeOffset>,
                // RedirectUri = <string>
            };

            await HttpContext.SignInAsync("CookieAuth", new ClaimsPrincipal(claimsIdentity), authProperties);

            return RedirectToPage("/Index");
        }

        StatusMsg = "Wrong Username or Password";
        return Page();
    }
}
