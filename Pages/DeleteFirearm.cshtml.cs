using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Gunventory.Data;
using Microsoft.AspNetCore.Authorization;

namespace Gunventory.Pages;

[Authorize]
public class DeleteFirearmModel : PageModel
{
    private readonly GunventoryContext _context;

    public DeleteFirearmModel(GunventoryContext context)
    {
        _context = context;
    }

    public async Task<IActionResult> OnGetAsync(int? id)
    {
        if (id == null)
        {
            return NotFound();
        }

        var firearm = await _context.Firearms.FindAsync(id);

        if (firearm != null)
        {
            firearm.Status = "I";
            await _context.SaveChangesAsync();
        }

        return RedirectToPage("/Index");
    }
}
