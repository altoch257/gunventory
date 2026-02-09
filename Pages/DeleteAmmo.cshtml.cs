using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Gunventory.Data;
using Microsoft.AspNetCore.Authorization;

namespace Gunventory.Pages;

[Authorize]
public class DeleteAmmoModel : PageModel
{
    private readonly GunventoryContext _context;

    public DeleteAmmoModel(GunventoryContext context)
    {
        _context = context;
    }

    public async Task<IActionResult> OnGetAsync(int? id)
    {
        if (id == null)
        {
            return NotFound();
        }

        var ammo = await _context.Ammunitions.FindAsync(id);

        if (ammo != null)
        {
            ammo.Status = "I";
            await _context.SaveChangesAsync();
        }

        return Redirect(Request.Headers["Referer"].ToString() ?? "/Index");
    }
}
