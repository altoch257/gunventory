using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using Gunventory.Data;
using Gunventory.Models;
using Microsoft.AspNetCore.Authorization;

namespace Gunventory.Pages;

[Authorize]
public class AccessoryDetailsModel : PageModel
{
    private readonly GunventoryContext _context;

    public AccessoryDetailsModel(GunventoryContext context)
    {
        _context = context;
    }

    public Accessory Accessory { get; set; } = default!;

    public async Task<IActionResult> OnGetAsync(int? id)
    {
        if (id == null)
        {
            return NotFound();
        }

        Accessory = await _context.Accessories
            .Include(a => a.Firearm)
            .FirstOrDefaultAsync(m => m.Id == id);

        if (Accessory == null)
        {
            return NotFound();
        }

        return Page();
    }
}
